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
use App\Models\User;
use App\Mail\SendMailActivitySignUp;

class MollieWebhookController extends BaseWebhookController
{
    protected function getTransactionObject($pid)
    {
        return Transaction::with(['contribution' => function ($query) {
            $query->orderBy('created_at', 'asc')->take(1);
        }])->where('transactionId', $pid)->first();


        //return Transaction::where('transactionId', $pid)->with('contribution')->first();
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
                    $order->paymentStatus = paymentStatus::paid;
                    $order->save();
                    if ($order->product->index == null) {
                        $email = $order->email;
                        if($email == null){
                            $email = $order->contribution->first()->email;
                        }
                        Mail::to($email)
                            ->send(new SendMailActivitySignUp($order->product->name, $order->product));
                        return response(null, 200);
                    }

                    if ($order->product->index == paymentType::intro) {
                        IntroController::postProcessPayment($order);
                        return response(null, 200);
                    }
                    // This is an activity \/

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
                $order->handlePaymentPaid();
                InschrijfController::processPayment($orderReg);
                return response(null, 200);
            }
        }

        if ($payment->isOpen()) {
            if($order != null){
                $order->paymentStatus = paymentStatus::open;
                $order->save();
            }
        }

        if ($payment->isFailed()) {
            if($order != null){
                $order->paymentStatus = paymentStatus::failed;
                $order->save();
            } else {
                $orderReg = Transaction::where('transactionId', null)->with('contribution')->latest()->first();
                $user = $orderReg->contribution()->first();
                $user->forceDelete();
            }
        }

        if ($payment->isCanceled()) {
            if($order != null) {
                $order->paymentStatus = paymentStatus::canceled;
                $order->save();
                if($order->type == paymentType::intro)
                {
                    $introObject = $order->introRelation;
                    Mail::to($introObject->email)
                        ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
                    $introObject->delete();
                }
            } else {
                $orderReg = Transaction::where('transactionId', null)->with('contribution')->latest()->first();
                $user = $orderReg->contribution()->first();
                $user->forceDelete();
            }
        }

        if ($payment->isExpired()) {
            if($order != null){
                $order->paymentStatus = paymentStatus::expired;
                $order->save();
                if($order->type == paymentType::intro)
                {
                    $introObject = $order->introRelation;
                    Mail::to($introObject->email)
                        ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
                    $introObject->delete();
                }
            } else {
                $orderReg = Transaction::where('transactionId', null)->with('contribution')->latest()->first();
                $user = $orderReg->contribution()->first();
                $user->forceDelete();
            }
        }

        if ($payment->isPending()) {
            $order->paymentStatus = paymentStatus::pending;
            $order->save();
        }
    }
}
