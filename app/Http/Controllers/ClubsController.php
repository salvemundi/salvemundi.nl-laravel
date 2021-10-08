<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Club;

use Illuminate\Http\Request;

class ClubsController extends Controller
{
    public function index() {
        $clubs = Club::all();
        return view('clubs', ['clubs' => $clubs]);
    }

    public function adminIndex() {
        $clubs = Club::all();
        return view('admin/clubs', ['clubs' => $clubs]);
    }

    public function store(Request $request) {
        $request->validate([
            'clubName' => 'required',
            'whatsappLink' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if ($request->input('id') == null) {
            $clubs = new Club;
            $message = 'Club aangemaakt';
        }
        else {
            $clubs = Club::find($request->input('id'));
            $message = 'Club aangepast';
        }

        $clubs->clubName = $request->input('clubName');
        $clubs->founderName = $request->input('founderName');
        $clubs->nickName = $request->input('nickName');
        $clubs->imgPath = $request->input('imgPath');

        if($request->file('photo') != null) {
            $request->file('photo')->storeAs (
                'public/clubs', $request->input('clubName').".png"
            );
            $clubs->imgPath = 'clubs/'.$request->input('clubName').".png";
        }

        $clubs->whatsappLink = $request->input('whatsappLink');
        $clubs->discordLink = $request->input('discordLink');
        $clubs->otherLink = $request->input('otherLink');

        $clubs->save();

        return redirect('admin/clubs')->with('message', $message);
    }

    public function edit(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        return view('admin/clubsEdit', ['clubs' => Club::find($request->input('id'))]);
    }

    public function delete(Request $request) {
        if ($request->id != null) {
            $tobeDeleted = Club::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/clubs')->with('message', 'Club is verwijderd');
        }
        else {
            return redirect('admin/clubs');
        }
    }
}
