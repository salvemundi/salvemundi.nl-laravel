<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Models\Intro;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailIntro;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\FirstPaymentPaid;
use Laravel\Cashier\FirstPayment\FirstPaymentHandler;
use Laravel\Cashier\Http\Controllers\BaseWebhookController;
use Laravel\Cashier\Order\Order;
use Mollie\Laravel\Facades\Mollie;
use App\Enums\paymentType;
use App\Models\Transaction;
use PharIo\Manifest\Exception;

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
                    //if ($order->product->index == paymentType::registration) {
                        //$order->paymentStatus = paymentStatus::paid;
                        //$order->save();
                $order = (new FirstPaymentHandler($paymentRegister))->execute();
                if(Order::where('mollie_payment_id',$paymentId)->first()->mollie_payment_status != 'paid') {
                    $orderReg = Transaction::where('transactionId' == null)->last();
                    $orderReg->transactionId = $paymentId;
                    $orderReg->save();
                    Event::dispatch(new FirstPaymentPaid($paymentRegister, $order));
                    Log::info('Webhook');
                    $order->handlePaymentPaid();
                    //$orderObject = Order::all()->last()->first();
                    Log::info($orderReg);
                    InschrijfController::processPayment($orderReg);
                    return response(null, 200);
                }
                //}
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
