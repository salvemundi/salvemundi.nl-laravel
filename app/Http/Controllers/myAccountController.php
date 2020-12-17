<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class myAccountController extends Controller
{
    public function index(){
        Session::get('user');
        $getUser = DB::table('users')->where('AzureID', '=', session('id'))->get();
        //dd($getUser);
        return view('mijnAccount', ['user' => $getUser]);
    }
}
