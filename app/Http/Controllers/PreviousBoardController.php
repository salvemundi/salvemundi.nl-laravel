<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreviousBoard;

class PreviousBoardController extends Controller
{
    public function index()
    {
        $previousBoard = PreviousBoard::orderBy('year', 'DESC')->get();
        return view('previousBoard',['previousBoard' => $previousBoard]);
    }
}
