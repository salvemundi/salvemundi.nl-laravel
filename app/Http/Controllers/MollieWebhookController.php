<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailIntro;
use Laravel\Cashier\FirstPayment\FirstPaymentHandler;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\BaseWebhookController;
use Mollie\Laravel\Facades\Mollie;
use App\Enums\paymentType;
use App\Models\Transaction;


class MollieWebhookController extends BaseWebhookController
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
        $paymentRegister = $this->getPaymentById($request->get('id'));

        if ($payment->isPaid()) {
            if($order != null){
                if ($order->paymentStatus != paymentStatus::paid) {
                    if ($order->product->index == paymentType::intro) {
                        $order->paymentStatus = paymentStatus::paid;
                        $order->save();
                        IntroController::postProcessPayment($order);
                        return response(null, 200);
                    }
                } else {
                    return response(null, 200);
                }
            } else
            {
                $order = (new FirstPaymentHandler($paymentRegister))->execute();
                $orderReg = Transaction::where('transactionId', null)->latest()->first();
                $orderReg->transactionId = $paymentId;
                $orderReg->paymentStatus = paymentStatus::paid;
                $orderReg->save();
                Log::info('Webhook');
                $order->handlePaymentPaid();
                Log::info($order);
                Log::info($orderReg);
                InschrijfController::processPayment($orderReg);
                return response(null, 200);
            }
        }

        if ($payment->isOpen()) {
            $order->paymentStatus = paymentStatus::open;
            $order->save();
        }

        if ($payment->isFailed()) {
            $order->paymentStatus = paymentStatus::failed;
            $order->save();
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
