<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sticker;
use App\Models\User;

class StickerController extends Controller
{
    public function index() {
        $stickers = Sticker::all();
        $userFound = User::where('AzureID', session('id'))->first();
        $userStickers = [];

        if ($userFound != null) {
            foreach ($stickers as $sticker) {
                if ($sticker->userId == $userFound->id) {
                    array_push($userStickers, $sticker);
                }
            }
        }

        return view('/sticker', ['stickers' => $stickers, 'userStickers' => $userStickers, 'userFound' => $userFound]);
    }

    public function store(Request $request) {
        $request->validate([
            'longitude' =>  ['required', 'regex:/(^[0-9.]+$)+/'],
            'latitude'  =>  ['required', 'regex:/(^[0-9.]+$)+/'],
        ]);

        $sticker = new Sticker;

        $sticker->userId = $request->input('userId');
        $sticker->longitude = $request->input('longitude');
        $sticker->latitude = $request->input('latitude');

        $sticker->save();

        return redirect('/stickers')->with('message', 'Sticker is toegevoegd!');
    }

    public function delete(Request $request) {
        if ($request->id != null) {
            $stickerToDelete = Sticker::find($request->id);

            $userFound = User::where('AzureID', session('id'))->first();

            if ($userFound->id == $stickerToDelete->userId) {
                $stickerToDelete->delete();

                return redirect('/stickers')->with('information', 'Sticker verwijderd!');
            }
            return redirect('/stickers')->with('error', 'Beste Sukkel, jij dacht dit te doen. HaHa, nice try kut hacker!');
        } else {
            return redirect('/stickers');
        }
    }
}
