<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreviousBoard;

class PreviousBoardController extends Controller
{
    public function index()
    {
        $previousBoard = PreviousBoard::orderBy('year', 'DESC')->get();
        $bestuur = PreviousBoard::all()->count();
        // dd($bestuur)
        return view('previousBoard',['previousBoard' => $previousBoard, 'bestuur' => $bestuur]);
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
            'year' => 'required|max:10|regex:/(^[0-9]+$)+/',
        ]);
        $newBestuur = new PreviousBoard();
        if ($request->file('fotoPath') != null)
        {
            $path = $request->file('fotoPath')->storeAs(
                'public/images/previousBoardPictures', $request->input('year').".png"
            );
            $newBestuur->fotoPath = 'images/previousBoardPictures/'.$request->input('year').".png";
        }

        $newBestuur->bestuur = $request->input('bestuur');
        $newBestuur->year = $request->input('year');
        $newBestuur->save();
        return redirect('admin/oud-bestuur/')->with('message', 'Oud bestuur toegevoegd');
    }

    public function delete(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = PreviousBoard::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/oud-bestuur')->with('information', 'Oud bestuur verwijderd');
        } else {
            return redirect('admin/oud-bestuur');
        }
    }
}
