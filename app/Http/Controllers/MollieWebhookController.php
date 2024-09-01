<?php
declare(strict_types=1);

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
    }
    public function handle(Request $request = null , $paymentIdParam = null) {
        if ($request == null || !$request->has('id') && $paymentIdParam == null) {
            return;
        }

        $paymentId = $request->input('id') ?? $paymentIdParam;
        $payment = Mollie::api()->payments->get($paymentId);
        $order = $this->getTransactionObject($paymentId);
        $paymentRegister = $this->getMolliePaymentById($request->get('id'));
        if ($payment->isPaid()) {
            if($order != null){
                if ($order->paymentStatus != paymentStatus::paid) {
                    $order->paymentStatus = paymentStatus::paid;
                    $order->save();
                    if ($order->product->index == null) {
                        if($payment->metadata->email != "null") {
                            Log::info('non member email' . $payment->metadata->email);
                            Mail::to($payment->metadata->email)
                                ->send(new SendMailActivitySignUp($order->product->name, $order->product));
                        }
                        if($payment->metadata->userId != "null") {
                            $userObject = User::find($payment->metadata->userId);
                            $userObject->activities()->attach($order->product);
                            $userObject->save();
                            Log::info('member email' . $userObject->email);
                            Mail::to($userObject->email)
                                ->send(new SendMailActivitySignUp($order->product->name, $order->product));
                        }
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
                if($orderReg->coupon != null) {
                    if(!$orderReg->coupon->hasBeenUsed && $orderReg->coupon->isOneTimeUse) {
                        $orderReg->coupon->hasBeenUsed = true;
                        $orderReg->coupon->save();
                    }
                }
                $orderReg->save();
                $order->handlePaymentPaid($paymentRegister);
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
