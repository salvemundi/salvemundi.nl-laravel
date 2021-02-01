<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use App\Models\WhatsappLink;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Enums\paymentType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class myAccountController extends Controller
{
    public function index(){
        //Session::get('user');
        $userObject = User::where('AzureID', session('id'))->first();
        $getUser = AzureUser::where('AzureID', session('id'))->first();
        $adminAuthorization = AdminController::authorizeUser(session('id'));
        $status = 0;

        $plan = paymentType::fromValue(3);
        $name = ucfirst($plan) . ' membership';

        Log::info($userObject->subscribed($name,$plan->key));
        if($userObject->subscribed($name,$plan->key))
        {
            $status = 1;
        }
        if($adminAuthorization == 401){
            return abort(401);
        } else {
            $whatsappLinks = WhatsappLink::all();
            return view('mijnAccount', ['user' => $getUser, 'authorized' => $adminAuthorization,'whatsapplink' => $whatsappLinks,'subscriptionActive' => $status,'transactions' => $getUser->payment]);
        }
    }

    public function savePreferences(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = AzureUser::find($request->input('user_id'));

        if($request->input('cbx'))
        {
            $user->visibility = 1;
            $message = 'Je bent nu te zien op de website';
        } else {
            $user->visibility = 0;
            $message = 'Je bent nu niet meer te zien op de website';
        }

        if($user->ImgPath == 'images/SalveMundi-Vector.svg')
        {
            $request->file('photo')->storeAs('public/users/',$user->AzureID.'.jpg');
            $user->ImgPath = 'users/'.$user->AzureID;
            $user->save();
            if(!AzureController::updateProfilePhoto($user)){
                return redirect('/mijnAccount')->with('message', 'Er is iets fout gegaan met het bijwerken van je foto op Office365, probeer het later opnieuw.');
            }
        }
        else
        {
            $request->file('photo')->storeAs('public/users/',$user->AzureID.'.jpg');
            $user->ImgPath = 'users/'.$user->AzureID.'.jpg';
            if(!AzureController::updateProfilePhoto($user)){
                return redirect('/mijnAccount')->with('message', 'Er is iets fout gegaan met het bijwerken van je foto op Office365, probeer het later opnieuw.');
            }
        }

        $user->save();
        $message = 'Je foto is bewerkt';

        return redirect('/mijnAccount')->with('message', $message);
    }
}
