<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchController extends Controller
{
    public function view(Request $request) {
        dd($request->getRequestUri());
    }

}
