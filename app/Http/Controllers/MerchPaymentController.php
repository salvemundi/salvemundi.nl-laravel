<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Models\Merch;
use App\Models\MerchSize;
use App\Models\Transaction;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mollie\Api\Resources\Payment;
use Mollie\Laravel\Facades\Mollie;

class MerchPaymentController extends Controller
{
    public function HandlePurchase(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $merch = Merch::find($request->id);
        $size = MerchSize::find($request->input('merchSize'));
        if($merch == null || $size == null) return back()->with('error','Het item wat u probeert te kopen bestaat niet in ons systeem');

        if($merch->merchSizes->find($request->input('merchSize'))->pivot->amount > 0) {
            return redirect($this->CreatePayment($merch, $size)->getCheckoutUrl());
        } else {
            return back()->with('error','Dit item is intussen helaas niet meer op voorraad.');
        }
    }

    private function CreatePayment(Merch $merch, MerchSize $merchSize): Payment
    {
        $user = Auth::user();
        $transaction = new Transaction();
        $transaction->amount = $merch->calculateDiscount();
        $transaction->save();
        $transaction->contribution()->attach($user);
        $transaction->merch()->associate($merch);
        $merch->userOrders()->attach($user);

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
            ],
            "webhookUrl" => env('NGROK_LINK') ? env('NGROK_LINK')."/webhooks/mollie/merch" : route('webhooks.mollie.merch'),
        ]);
        $transaction->transactionId = $payment->id;
        $transaction->save();
        return $payment;
    }

    public function HandlePayment(Request $request) {
        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments->get($paymentId);

        if ($payment->isPaid())
        {
            // Deduce the inventory amount by one.
            $merch = Merch::find($payment->metadata->merchId);
            $pivot = $merch->merchSizes->find($payment->metadata->sizeId)->pivot;
            $pivot->amount = --$pivot->amount;
            $pivot->save();
            // Update the payment status
            $transaction = Transaction::where('transactionId',$payment->id)->first();
            $transaction->paymentStatus = paymentStatus::paid()->value;
            $transaction->save();

            return response(null,200);
        }
    }
}
