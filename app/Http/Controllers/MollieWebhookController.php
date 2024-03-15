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
    protected function getTransactionObject($pid): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|null
    {
        return Transaction::with(['contribution' => function ($query) {
            $query->orderBy('created_at', 'asc')->take(1);
        }])->where('transactionId', $pid)->first();
    }
    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $paymentId = $request->input('id');
        $payment = Mollie::api()->payments()->get($paymentId);
        $order = $this->getTransactionObject($paymentId) ?? (new FirstPaymentHandler($this->getMolliePaymentById($paymentId)))->execute();

        switch ($payment->status) {
            case 'paid':
                $order->paymentStatus = paymentStatus::paid;
                if ($order->product->index == null) {
                    $this->handleActivitySignUp($payment, $order);
                } elseif ($order->product->index == paymentType::intro) {
                    IntroController::postProcessPayment($order);
                }
                break;
            case 'open':
                $order->paymentStatus = paymentStatus::open;
                break;
            case 'failed':
            case 'canceled':
            case 'expired':
                $order->paymentStatus = paymentStatus::fromValue($payment->status);
                $this->handleFailedOrCanceledOrExpiredPayment($order);
                break;
            case 'pending':
                $order->paymentStatus = paymentStatus::pending;
                break;
    }

    $order->save();

    return response(null, 200);
}

    private function handleActivitySignUp($payment, $order): void
    {
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
    }

    private function handleFailedOrCanceledOrExpiredPayment($order): void
    {
        if($order->type == paymentType::intro) {
            $introObject = $order->introRelation;
            Mail::to($introObject->email)
                ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $order->paymentStatus));
            $introObject->delete();
        } else {
            $orderReg = Transaction::where('transactionId', null)->with('contribution')->latest()->first();
            $user = $orderReg->contribution()->first();
            $user->forceDelete();
        }
    }
}
