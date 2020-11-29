<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intro;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class InschrijvenController extends Controller
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

        Mail::to($userIntro->email)
                ->send(new SendMail($userIntro->firstName, $userIntro->lastName, $userIntro->insertion));

        return redirect('intro')->with('message', 'Inschrijf formulier is verstuurd');
    }
}
