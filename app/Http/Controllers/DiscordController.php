<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscordLink;

class DiscordController extends Controller
{
    public function redirect() {
        $link = DiscordLink::first();
        if($link == null) {
            return redirect('/');
        }
        return redirect($link->link);
    }

    public function save(Request $request) {
        $discord = null;
        if(DiscordLink::first() == null) {
            $discord = new DiscordLink;
        } else {
            $discord = DiscordLink::first();
        }
        $discord->link = $request->input('link');
        $discord->save();
        return redirect('/admin/socials');
    }

    public static function getLink() {
        return DiscordLink::first();
    }
}
