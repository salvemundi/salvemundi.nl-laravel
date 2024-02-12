<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\MerchGender;
use App\Enums\paymentStatus;
use App\Mail\MerchOrderPaid;
use App\Mail\MerchMinimumPreOrdersReached;
use App\Mail\MerchPreOrderReceived;
use App\Models\Merch;
use App\Models\MerchSize;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as Res;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Mollie\Api\Resources\Payment;
use Mollie\Laravel\Facades\Mollie;

class MerchPaymentController extends Controller
{

    private Transaction $transaction;

    public function handlePurchase(Request $request, Transaction $transaction): RedirectResponse
    {
        $request->validate([
            'id' => 'required|integer',
            'merchSize' => 'required|integer',
            'gender' => 'required|integer',
        ]);

        $merch = Merch::findOrFail($request->id);
        $size = MerchSize::findOrFail($request->input('merchSize'));
        $gender = MerchGender::coerce((int)$request->input('gender'));
        $user = Auth::user();

        $isInStock = $merch->merchSizes()->where('size_id', $size->id)->where('merch_gender', $gender->value)->first()->pivot->amount > 0;
        if ($merch->isPreOrder || $isInStock) {
            $this->saveData($merch, $size, $gender, $transaction, $user);
            if ($merch->preOrderNeedsPayment) {
                return redirect($this->createPayment($merch, $size, $gender, $transaction, $user)->getCheckoutUrl());
            } else {
                return $this->handlePreOrder($merch, $size, $gender, $transaction, $user);
            }
        } else {
            return back()->with('error', __('Dit item is intussen helaas niet meer op voorraad.'));
        }
    }

    private function saveData(Merch $merch, MerchSize $merchSize, MerchGender $gender, Transaction $transaction, User $user): void
    {
        $transaction->amount = $merch->calculateDiscount();
        $transaction->save();
        $transaction->contribution()->attach($user);
        $transaction->merch()->associate($merch);
        $transaction->save();
        $merch->userOrders()->attach($user, ['transaction_id' => $this->transaction->id, 'merch_gender' => $gender->value, 'merch_size_id' => $merchSize->id]);
    }

    private function handlePreOrder(Merch $merch, MerchSize $merchSize, MerchGender $gender, Transaction $transaction, User $user): RedirectResponse
    {
        $this->handleEmail($user, $merch, $merchSize, $gender, $transaction);
        return back()->with('success', 'Je pre order is geregistreerd!');
    }

    private function createPayment(Merch $merch, MerchSize $merchSize, MerchGender $gender, Transaction $transaction, User $user): Payment
    {
        $priceFormatted = number_format($merch->calculateDiscount(), 2, '.', '');
        $payment = Mollie::api()->payments()->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "$priceFormatted"
            ],
            "description" => "$merch->name",
            "redirectUrl" => route('home'),
            "metadata" => [
                ($user ? "userId" : null) => $user->id,
                "merchId" => $merch->id,
                "sizeId" => $merchSize->id,
                "genderId" => $gender->value
            ],
            "webhookUrl" => config('app.ngrok_link') ? config('app.ngrok_link') . "/webhooks/mollie/merch" : route('webhooks.mollie.merch'),
        ]);
        $transaction->transactionId = $payment->id;
        $transaction->save();
        return $payment;
    }

    public function handlePayment(Request $request): ResponseFactory|Res
    {
        $paymentId = $request->input('id');

        /** @var Payment */
        $payment = Mollie::api()->payments->get($paymentId);

        $transaction = Transaction::where('transactionId', $payment->id)->first();

        $statusMethods = ['isCanceled', 'isFailed', 'isExpired', 'isPending', 'isOpen', 'isPaid'];
        foreach ($statusMethods as $method) {
            if ($payment->$method()) {
                $transaction->paymentStatus = constant("paymentStatus::{$method}()->value");
                if (method_exists($this, $method)) {
                    $this->$method($payment, $transaction);
                }
                break;
            }
        }
        $transaction->save();
        return response(null, 200);
    }

    private function isPaid(Payment $payment, Transaction $transaction): void
    {
        // Deduce the inventory amount by one.
        $merch = Merch::find($payment->metadata->merchId);
        if (!$merch->isPreOrder) {
            $merch->merchSizes()
                ->where('merch_id', $payment->metadata->merchId)
                ->where('size_id', $payment->metadata->sizeId)
                ->where('merch_gender', $payment->metadata->genderId)
                ->decrement('amount', 1);
        }

        // send email
        $size = MerchSize::find($payment->metadata->sizeId);
        $merchGender = MerchGender::coerce($payment->metadata->genderId);
        $user = User::find($payment->metadata->userId);

        $this->handleEmail($user, $merch, $size, $merchGender, $transaction);
        return;
    }

    private function handleEmail(User $user, Merch $merch, MerchSize $size, MerchGender $merchGender, Transaction $transaction): void
    {

        if (!$merch->isPreOrder) {
            Mail::to($user)->send(new MerchOrderPaid($user, $merch, $size, $merchGender, $transaction));
        } else {
            Mail::to($user)->send(new MerchPreOrderReceived($user, $merch, $size, $merchGender, $transaction));
        }

        if ($merch->transactions->where('paymentStatus', paymentStatus::paid)->count() % (int)$merch->amountPreOrdersBeforeNotification == 0) {
            Mail::to(explode(',', config('app.merch_pre_order_mail_notification')))->send(new MerchMinimumPreOrdersReached($merch));
        }
        return;
    }
}
