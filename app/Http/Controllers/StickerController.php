<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Sticker;
use App\Models\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class StickerController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $stickers = Sticker::all();
        $user = Auth::user();
        $userStickers = [];

        if ($user != null) {
            foreach ($stickers as $sticker) {
                if ($sticker->userId == $user->id) {
                    array_push($userStickers, $sticker);
                }
            }
        }

        return view('/sticker', ['stickers' => $stickers, 'userStickers' => $userStickers]);
    }

    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'longitude' =>  ['required', 'regex:/(^[0-9.-]+$)+/'],
            'latitude'  =>  ['required', 'regex:/(^[0-9.-]+$)+/'],
        ]);

        $sticker = new Sticker;
        $user = Auth::user();

        $sticker->userId = $user->id;
        $sticker->longitude = $request->input('longitude');
        $sticker->latitude = $request->input('latitude');

        $sticker->save();

        return redirect('/stickers')->with('message', 'Sticker is toegevoegd!');
    }

    public function delete(Request $request) {
        if ($request->id != null) {
            $stickerToDelete = Sticker::find($request->id);

            $user = Auth::user();

            if ($user->id == $stickerToDelete->userId) {
                $stickerToDelete->delete();

                return redirect('/stickers')->with('information', 'Sticker verwijderd!');
            }
            return redirect('/stickers')->with('error', 'Kut hacker, optyfen gauw!');
        } else {
            return redirect('/stickers');
        }
    }
}
