<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Models\Intro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailIntro;
use Mollie\Laravel\Facades\Mollie;
use App\Enums\paymentType;
use App\Models\Transaction;

class MollieWebhookController extends Controller
{
    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }
        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments()->get($paymentId);

        if ($payment->isPaid()) {
            $order = Transaction::where('transactionId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::paid;
            $order->save();
            if($order->type == paymentType::fromValue(paymentType::intro))
            {
                $introObject = Intro::where('paymentId', $order->id)->first();
                Mail::to($introObject->email)
                    ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
            }
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
            Mail::to($order->email)
                ->send(new SendMailIntro($order->firstName, $order->lastName, $order->insertion, $order->paymentStatus));
            $order->delete();
        }

        if ($payment->isCanceled()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::canceled;
            $order->save();
            $order->delete();
            Mail::to($order->email)
                ->send(new SendMailIntro($order->firstName, $order->lastName, $order->insertion, $order->paymentStatus));
        }

        if ($payment->isExpired()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::expired;
            $order->save();
            $order->delete();
            Mail::to($order->email)
                ->send(new SendMailIntro($order->firstName, $order->lastName, $order->insertion, $order->paymentStatus));
        }

        if ($payment->isPending()) {
            $order = Intro::where('paymentId', $paymentId)->first();
            $order->paymentStatus = paymentStatus::pending;
            $order->save();
        }
    }
}
