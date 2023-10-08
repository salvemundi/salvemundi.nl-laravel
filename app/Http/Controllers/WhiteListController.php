<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WhiteListController extends Controller
{
    public function getWhiteList(){
        $list = User::select('minecraftUsername')
            ->where('minecraftUsername', '!=', 'NULL')
            ->pluck('minecraftUsername');
        return response()->json($list);
    }
}
