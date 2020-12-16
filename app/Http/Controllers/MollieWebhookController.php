<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use Illuminate\Http\Request;

class MollieWebhookController extends Controller
{

    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid()) {
            $order = Order::find($payment->id);
            $order->paymentStatus = paymentStatus::paid;
        }
    }
}
