<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Intro;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Redirect;
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
        if(Intro::where('email',$request->input('email')))
        {
            return view('intro',['message' => 'Een gebruiker met deze e-mail heeft zich al ingeschreven']);
        }
        $userIntro = new Intro;

        $userIntro->firstName = $request->input('firstName');
        $userIntro->insertion = $request->input('insertion');
        $userIntro->lastName = $request->input('lastName');
        $userIntro->birthday = $request->input('birthday');
        $userIntro->email = $request->input('email');
        $userIntro->phoneNumber = $request->input('phoneNumber');
        $userIntro->birthday = date("Y-m-d", strtotime($userIntro->birthday));
        $userIntro->save();
        return MolliePaymentController::processRegistration($userIntro, paymentType::intro);
        //return $this->preparePayment($userIntro->id)->with('message', 'Er is een E-mail naar u verstuurd met de betalingsstatus.');
    }
}
