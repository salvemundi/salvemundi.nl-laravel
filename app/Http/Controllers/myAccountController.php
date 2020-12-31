<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use Illuminate\Http\Request;
use Session;
use DB;

class myAccountController extends Controller
{
    public function index(){
        Session::get('user');
        //$getUser = DB::table('users')->where('AzureID', '=', session('id'))->get();
        $getUser = AzureUser::where('AzureID', session('id'))->first();
        //dd($getUser);
        $adminAuthorization = AdminController::authorizeUser(session('id'));
        if($adminAuthorization == 401){
            return abort(401);
        } else {
            return view('mijnAccount', ['user' => $getUser, 'authorized' => $adminAuthorization]);
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
