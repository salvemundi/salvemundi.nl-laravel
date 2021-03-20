<?php

namespace App\Http\Controllers;

use App\Enums\paymentType;
use App\Mail\SendMailInschrijving;
use App\Mail\SendMailInschrijvingTransactie;
use App\Models\Inschrijving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class InschrijfController extends Controller
{
    public function index()
    {
        return view('inschrijven');
    }

    public function signupprocess(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'max:32', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'insertion' => 'max:32',
            'lastName' => ['required', 'max:45', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'birthday' => 'required','date_format:"l, j F Y"',
            'email' => 'required|email|max:65',
            'phoneNumber' => 'required|max:10|regex:/(^[0-9]+$)+/',
        ]);

            $inschrijving = new Inschrijving;
            $inschrijving->firstName = $request->input('firstName');
            $inschrijving->insertion = $request->input('insertion');
            $inschrijving->lastName = $request->input('lastName');
            if($request->input('birthday') != null)
            {
                $inschrijving->birthday = $request->input('birthday');
                $inschrijving->birthday = date("Y-m-d", strtotime($inschrijving->birthday));
            }
            $inschrijving->email = $request->input('email');
            $inschrijving->phoneNumber = $request->input('phoneNumber');
            $inschrijving->save();
            return MolliePaymentController::processRegistration($inschrijving, paymentType::contribution);
    }

    public static function processPayment($orderObject)
    {
        $registerObject = $orderObject->registerRelation;
        if(AzureController::fetchSpecificUser($registerObject->user->AzureID)){
            AzureController::createAzureUser($registerObject, $orderObject);
        }
    }
}
