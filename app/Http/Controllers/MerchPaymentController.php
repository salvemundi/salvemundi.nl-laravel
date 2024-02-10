<?php

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


    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function HandlePurchase(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $merch = Merch::find($request->id);
        $size = MerchSize::find($request->input('merchSize'));
        $gender = MerchGender::coerce((int)$request->input('gender'));
        if ($merch == null || $size == null) return back()->with('error', 'Het item wat u probeert te kopen bestaat niet in ons systeem');
        if ($merch->isPreOrder || $merch->merchSizes()->where('size_id', $size->id)->where('merch_gender', $gender->value)->first()->pivot->amount > 0) {
            if($merch->preOrderNeedsPayment) {
                return redirect($this->CreatePayment($merch, $size, $gender)->getCheckoutUrl());
            } else {
                return $this->HandlePreOrder($merch, $size, $gender);
            }
        } else {
            return back()->with('error', 'Dit item is intussen helaas niet meer op voorraad.');
        }
    }

    private function SaveData(Merch $merch, MerchSize $merchSize, MerchGender $gender): void {
        $user = Auth::user();
        $this->transaction->amount = $merch->calculateDiscount();
        $this->transaction->save();
        $this->transaction->contribution()->attach($user);
        $this->transaction->merch()->associate($merch);
        $this->transaction->save();
        $merch->userOrders()->attach($user, ['transaction_id' => $this->transaction->id,'merch_gender' => $gender->value, 'merch_size_id' => $merchSize->id]);
    }

    private function HandlePreOrder(Merch $merch, MerchSize $merchSize, MerchGender $gender){
        $this->SaveData($merch, $merchSize, $gender);
        $this->HandleEmail(Auth::user(), $merch, $merchSize, $gender, $this->transaction);
        return back()->with('success','Je pre order is geregistreerd!');

    }

    private function CreatePayment(Merch $merch, MerchSize $merchSize, MerchGender $gender): Payment
    {
        $user = Auth::user();
        $this->SaveData($merch, $merchSize, $gender);
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
        $this->transaction->transactionId = $payment->id;
        $this->transaction->save();
        return $payment;
    }

    public function HandlePayment(Request $request): ResponseFactory|Res
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

        if(!$merch->isPreOrder) {
            Mail::to($user)->send(new MerchOrderPaid($user, $merch, $size, $merchGender, $transaction));
        } else {
            Mail::to($user)->send(new MerchPreOrderReceived($user, $merch, $size, $merchGender, $transaction));
        }

        if ($merch->transactions->where('paymentStatus', paymentStatus::paid)->count() % (int)$merch->amountPreOrdersBeforeNotification == 0) {
            Mail::to(explode(',', env('MAIL_NOTIFICATION_MERCH_PREORDER')))->send(new MerchMinimumPreOrdersReached($merch));
        }
        return;
    }
}
