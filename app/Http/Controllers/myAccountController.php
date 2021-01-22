<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use App\Models\WhatsappLink;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use DB;

class myAccountController extends Controller
{
    public function index(){
        //Session::get('user');
        $userObject = User::where('AzureID', session('id'))->first();
        $getUser = AzureUser::where('AzureID', session('id'))->first();
        $adminAuthorization = AdminController::authorizeUser(session('id'));
        if($adminAuthorization == 401){
            return abort(401);
        } else {
            $whatsappLinks = WhatsappLink::all();
            return view('mijnAccount', ['user' => $getUser, 'authorized' => $adminAuthorization,'whatsapplink' => $whatsappLinks,'subscriptionActive' => $userObject->subscribed('main'),'transactions' => $getUser->payment]);
        }
    }

    public function savePreferences(Request $request)
    {
        $user = AzureUser::find($request->input('user_id'));
        if($request->input('cbx'))
        {
            $user->visibility = 1;
        } else {
            $user->visibility = 0;
        }
        $user->save();
        return redirect('/mijnAccount');
    }


}