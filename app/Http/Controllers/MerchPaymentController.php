<?php

namespace App\Http\Controllers;

use App\Enums\MerchGender;
use App\Enums\paymentStatus;
use App\Mail\MerchOrderPaid;
use App\Mail\MerchMinimumPreOrdersReached;
use App\Models\Merch;
use App\Models\MerchSize;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\Resources\Payment;
use Mollie\Laravel\Facades\Mollie;

class MerchPaymentController extends Controller
{
    public function HandlePurchase(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $merch = Merch::find($request->id);
        $size = MerchSize::find($request->input('merchSize'));
        $gender = MerchGender::coerce((int)$request->input('gender'));
        if ($merch == null || $size == null) return back()->with('error', 'Het item wat u probeert te kopen bestaat niet in ons systeem');
        if ($merch->merchSizes()->where('size_id', $size->id)->where('merch_gender', $gender->value)->first()->pivot->amount > 0 || $merch->isPreOrder) {
            return redirect($this->CreatePayment($merch, $size, $gender)->getCheckoutUrl());
        } else {
            return back()->with('error', 'Dit item is intussen helaas niet meer op voorraad.');
        }
    }

    private function CreatePayment(Merch $merch, MerchSize $merchSize, MerchGender $gender): Payment
    {
        $user = Auth::user();
        $transaction = new Transaction();
        $transaction->amount = $merch->calculateDiscount();
        $transaction->save();
        $transaction->contribution()->attach($user);
        $transaction->merch()->associate($merch);
        $merch->userOrders()->attach($user, ['merch_gender' => $gender->value, 'merch_size_id' => $merchSize->id]);

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
            "webhookUrl" => env('NGROK_LINK') ? env('NGROK_LINK') . "/webhooks/mollie/merch" : route('webhooks.mollie.merch'),
        ]);
        $transaction->transactionId = $payment->id;
        $transaction->save();
        return $payment;
    }

    public function HandlePayment(Request $request)
    {
        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments->get($paymentId);

        if ($payment->isPaid()) {
            // Deduce the inventory amount by one.
            $merch = Merch::find($payment->metadata->merchId);
            if (!$merch->isPreOrder) {
                $merch->merchSizes()
                    ->where('merch_id', $payment->metadata->merchId)
                    ->where('size_id', $payment->metadata->sizeId)
                    ->where('merch_gender', $payment->metadata->genderId)
                    ->decrement('amount', 1);
            }

            // Update the payment status
            $transaction = Transaction::where('transactionId', $payment->id)->first();
            $transaction->paymentStatus = paymentStatus::paid()->value;
            $transaction->save();

            // send email
            $size = MerchSize::find($payment->metadata->sizeId);
            $merchGender = MerchGender::coerce($payment->metadata->genderId);
            $user = User::find($payment->metadata->userId);

            $this->HandleEmail($user, $merch, $size, $merchGender, $transaction);

            return response(null, 200);
        }
    }

    private function HandleEmail(User $user, Merch $merch, MerchSize $size, MerchGender $merchGender, Transaction $transaction): void
    {
        Mail::to($user)->send(new MerchOrderPaid($user, $merch, $size, $merchGender, $transaction));

        if ($merch->transaction->count() % (int)$merch->amountPreOrdersBeforeNotification == 0) {
            Mail::to(explode(',', env('MAIL_NOTIFICATION_MERCH_PREORDER')))->send(new MerchMinimumPreOrdersReached($merch));
        }
        return;
    }
}
