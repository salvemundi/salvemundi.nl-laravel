<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Models\Intro;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MollieWebhookController extends Controller
{
    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }
        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments()->get($paymentId);

        if ($payment->isPaid()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::paid;
            $order->save();
        }
        if ($payment->isOpen()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::open;
            $order->save();
        }
        if ($payment->isFailed()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::failed;
            $order->save();
        }
        if ($payment->isCanceled()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::canceled;
            $order->save();
        }
        if ($payment->isExpired()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::expired;
            $order->save();
        }
        if ($payment->isPending()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::pending;
            $order->save();
        }
    }
}
