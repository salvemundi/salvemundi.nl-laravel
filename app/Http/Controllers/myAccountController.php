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

        return view('mijnAccount', ['user' => $getUser]);
    }
}
