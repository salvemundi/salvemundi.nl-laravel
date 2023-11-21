<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class MerchController extends Controller
{
    public function view(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('merch');
    }

    public function adminView(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merch');
    }

}
