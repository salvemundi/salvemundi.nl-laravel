<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Intro;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailIntro;
use Mollie\Laravel\Facades\Mollie;
use BenSampo\Enum\Enum;
use App\Enums\paymentStatus;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MolliePaymentController;
use App\Enums\paymentType;

class IntroController extends Controller
{
    public function index()
    {
        return view('intro');
    }

    public function store(Request $request)
    {
            $request->validate([
            'firstName' => ['required', 'max:32', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'insertion' => 'max:32',
            'lastName' => ['required', 'max:45', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'birthday' => 'required','date_format:"l, j F Y"',
            'email' => 'required|email|max:65',
            'phoneNumber' => 'required|max:10|regex:/(^[0-9]+$)+/',
            ]);

        $userIntro = new Intro;

        $userIntro->firstName = $request->input('firstName');
        $userIntro->insertion = $request->input('insertion');
        $userIntro->lastName = $request->input('lastName');
        $userIntro->birthday = $request->input('birthday');
        $userIntro->email = $request->input('email');
        $userIntro->phoneNumber = $request->input('phoneNumber');
        $userIntro->birthday = date("Y-m-d", strtotime($userIntro->birthday));

        $userIntro->save();
        $orderId = Intro::where('email', $request->input('email'));

        return $this->preparePayment($userIntro->id)->with('message', 'Er is een E-mail naar u verstuurd met de betalingsstatus.');
    }

    public function preparePayment($introId)
    {
        $introObject = Intro::find($introId);
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "69.00" // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Intro inschrijving",
            "redirectUrl" => route('intro'),
            "webhookUrl" => route('webhooks.mollie'),
            "metadata" => [
                "type" => paymentType::intro,
            ],
        ]);

      /*  $introObject->payment->create([
            'transactionId' => $payment->id,
            'paymentType' => paymentType::intro,
        ]);*/
        $transaction = new Transaction();
        $transaction->transactionId = $payment->id;
        $transaction->type = paymentType::intro;
        $transaction->save();

        $introObject->payment()->associate($transaction);
        $introObject->save();
        // redirect customer to Mollie checkout page
        return Redirect::to($payment->getCheckoutUrl());
    }
}
