<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Models\Intro;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Log;

class MollieWebhookController extends Controller
{
    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments()->get($paymentId);

        if ($payment->isPaid()) {
            $order = Intro::where('paymentId', $paymentId)->get();
            $order->paymentStatus = paymentStatus::paid;
            Log::debug($paymentId);
            Log::debug($order);
            $order->save();
        }
    }
}
