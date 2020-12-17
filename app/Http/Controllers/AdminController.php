<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Enums\paymentStatus;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function show()
    {
        $signins = DB::table('introduction')->get();
        // dd($signins);

        return view('admin',['signins' => $signins]);
    }
}
