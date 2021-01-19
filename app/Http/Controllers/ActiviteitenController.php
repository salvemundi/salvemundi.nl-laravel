<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ActiviteitenController extends Controller
{
    public function run(){
        $activiteiten = Product::where('index', null)->get();
        return view('activiteiten', ['activiteiten' => $activiteiten]);
    }
}
