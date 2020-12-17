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
            $order = Intro::where('paymentId', $paymentId)->get();
            $order->push(['paymentStatus' => paymentStatus::paid]);
        }
    }
}
