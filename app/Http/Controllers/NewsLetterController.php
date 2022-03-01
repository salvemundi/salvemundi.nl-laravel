<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLetter;

class NewsLetterController extends Controller
{
    public function index()
    {
        $newsletter = NewsLetter::orderBy('id', 'DESC')->get();
        return view('newsletter', ['newsletters' => $newsletter]);
    }

    public function indexAdmin()
    {
        $newsletter = NewsLetter::all();
        return view('admin/newsletter', ['newsletter' => $newsletter]);
    }

    public function store(Request $request){
        $request->validate([
            'filePath' => 'required|mimes:pdf|max:10000',
            'name' => 'required',
        ]);
        $newFile = new NewsLetter();
        $path = $request->file('filePath')->storeAs(
            'public/files/newsletter', $request->input('name').".pdf"
        );
        $newFile->name = $request->input('name');
        $newFile->filePath = 'files/newsletter/'.$request->input('name').".pdf";
        $newFile->save();
        return redirect('/admin/newsletter')->with('message', 'PDF toegevoegd');
    }

    public function delete(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = NewsLetter::find($request->id);
            $tobeDeleted->delete();
            return redirect('admin/newsletter')->with('information', 'PDF verwijderd');
        } else {
            return redirect('admin/newsletter');
        }
    }
}
