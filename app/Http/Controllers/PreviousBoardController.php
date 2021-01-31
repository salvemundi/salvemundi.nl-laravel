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

    public function indexAdmin()
    {
        $previousBoard = PreviousBoard::orderBy('year', 'DESC')->get();
        return view('admin/previousBoard',['previousBoard' => $previousBoard]);
    }

    public function addBestuur(Request $request)
    {
        $request->validate([
            'fotoPath' => '|image|mimes:jpeg,png,jpg,svg|max:2048',
            'bestuur' => 'required',
            'year' => 'required',
        ]);
        $newBestuur = new PreviousBoard();
        $path = $request->file('fotoPath')->storeAs(
            'public/images/previousBoardPictures', $request->input('year').".png"
        );
        $newBestuur->bestuur = $request->input('bestuur');
        $newBestuur->year = $request->input('year');
        $newBestuur->fotoPath = 'images/previousBoardPictures/'.$request->input('year').".png";
        $newBestuur->save();
        return redirect('admin/oud-bestuur/');
    }

    public function delete(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = PreviousBoard::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/oud-bestuur');
        } else {
            return redirect('admin/oud-bestuur');
        }
    }
}
