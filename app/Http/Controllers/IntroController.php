<?php

namespace App\Http\Controllers;

use App\Mail\SendMailIntro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Intro;
use App\Models\IntroData;
use App\Enums\paymentType;
use App\Models\AdminSetting;
use Illuminate\Support\Facades\Mail;
use App\Exports\introInschrijving;
use Maatwebsite\Excel\Facades\Excel;

class IntroController extends Controller
{
    public function index()
    {
        return view('intro');
    }

    public function store(Request $request)
    {
        $AdminSetting = AdminSetting::where('settingName','intro')->first();
        if($AdminSetting->settingValue == 1){
            $request->validate([
            'firstName' => ['required', 'max:32', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'insertion' => 'max:32',
            'lastName' => ['required', 'max:45', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'birthday' => 'required','date_format:"l, j F Y"',
            'email' => 'required|email|max:65',
            'phoneNumber' => 'required|max:10|regex:/(^[0-9]+$)+/',
            'firstNameParent' => 'max:32',
            'lastNameParent' => 'max:45',
            'addressParent' => 'max:65',
            'phoneNumberParent' => 'max:10',
            'checkbox' =>'accepted',
            'checkboxCorona' =>'accepted'
            ]);
            if(Intro::where('email',$request->input('email'))->first())
            {
                return redirect('introconfirm')->with('message', 'Een gebruiker met deze e-mail heeft zich al ingeschreven');
            }
            $userIntro = new Intro;

            $userIntro->firstName = $request->input('firstName');
            $userIntro->insertion = $request->input('insertion');
            $userIntro->lastName = $request->input('lastName');
            $userIntro->email = $request->input('email');
            if(!$request->input('birthday') == ""){
                $userIntro->birthday = $request->input('birthday');
                $userIntro->firstNameParent = $request->input('firstNameParent');
                $userIntro->lastNameParent = $request->input('lastNameParent');
                $userIntro->addressParent = $request->input('addressParent');
                $userIntro->phoneNumberParent = $request->input('phoneNumberParent');
                $userIntro->phoneNumber = $request->input('phoneNumber');
                $userIntro->medicalIssues = $request->input('medicalIssues');
                $userIntro->specials = $request->input('specials');
                $userIntro->birthday = date("Y-m-d", strtotime($userIntro->birthday));
                //dd($userIntro);
                $userIntro->save();
                return MolliePaymentController::processRegistration($userIntro, paymentType::intro);
            }
            $userIntro->save();
            return redirect('introconfirm')->with('message', 'Je hebt je ingeschreven voor de intro!');
        } else {
            return redirect('/');
        }
        //return $this->preparePayment($userIntro->id)->with('message', 'Er is een E-mail naar u verstuurd met de betalingsstatus.');
    }
    public function confirmview()
    {
        return view('introConfirm');
    }

    public static function postProcessPayment($paymentObject)
    {
        $introObject = $paymentObject->introRelation;
        Log::info($introObject);
        Mail::to($introObject->email)
            ->send(new SendMailIntro($introObject->firstName, $introObject->lastName, $introObject->insertion, $paymentObject->paymentStatus));
    }

    public function storeData(Request $request)
    {
        $AdminSetting = AdminSetting::where('settingName','intro')->first();
        if($AdminSetting->settingValue == 1){
            $request->validate([
            'firstName' => ['required', 'max:32', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'insertion' => 'max:32',
            'lastName' => ['required', 'max:45', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'email' => 'required|email|max:65',
            ]);
            if(IntroData::where('email',$request->input('email'))->first())
            {
                return view('intro',['message' => 'Een gebruiker met deze e-mail heeft zich al ingeschreven']);
            }
            $userIntro = new IntroData;

            $userIntro->firstName = $request->input('firstName');
            $userIntro->insertion = $request->input('insertion');
            $userIntro->lastName = $request->input('lastName');
            $userIntro->email = $request->input('email');
            $userIntro->save();
            // dd($userIntro);
            return view('intro',['message' => 'Je inschrijving is gelukt. Houd je mail in de gaten!']);
        } else {
            return redirect('/');
        }
    }
    function excel()
    {
        return Excel::download(new introInschrijving, 'introInschrijvingen.xlsx');
    }
}
