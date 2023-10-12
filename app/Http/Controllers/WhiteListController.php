<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WhiteListController extends Controller
{
    public function getWhiteList(){
        $arr = [];
        $list = User::where('minecraftUsername', '!=', 'NULL')->get();
        foreach($list as $user) {
            if($user->hasActiveSubscription()) {
               $arr[] = $user->minecraftUsername;
            }
        }
        return response()->json($arr);
    }
}
