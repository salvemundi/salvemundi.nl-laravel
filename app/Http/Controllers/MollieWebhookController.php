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
    protected function getTransactionObject($pid)
    {
        return Transaction::where('transactionId', $pid)->first();
    }
    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }
        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments()->get($paymentId);
        $order = $this->getTransactionObject($paymentId);

        if ($payment->isPaid()) {
            $order->paymentStatus = paymentStatus::paid;
            $order->save();
            if($order->type == paymentType::intro)
            {
                $introObject = $order->introRelation;
                Mail::to($introObject->email)
                    ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
            }
        }

        if ($payment->isOpen()) {
            $order->paymentStatus = paymentStatus::open;
            $order->save();
        }

        if ($payment->isFailed()) {
            $order->paymentStatus = paymentStatus::failed;
            $order->save();
            if($order->type == paymentType::intro)
            {
                $introObject = $order->introRelation;
                Mail::to($introObject->email)
                    ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
                $introObject->delete();
            }
        }

        if ($payment->isCanceled()) {
            $order->paymentStatus = paymentStatus::canceled;
            $order->save();
            if($order->type == paymentType::intro)
            {
                $introObject = $order->introRelation;
                Mail::to($introObject->email)
                    ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
                $introObject->delete();
            }
        }

        if ($payment->isExpired()) {
            $order->paymentStatus = paymentStatus::expired;
            $order->save();
            if($order->type == paymentType::intro)
            {
                $introObject = $order->introRelation;
                Mail::to($introObject->email)
                    ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
                $introObject->delete();
            }
        }

        if ($payment->isPending()) {
            $order->paymentStatus = paymentStatus::pending;
            $order->save();
        }
    }
}
