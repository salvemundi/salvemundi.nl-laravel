<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceDocuments;

class FinanceController extends Controller
{
    public function index()
    {
        $financeDocument = FinanceDocuments::latest()->first();
        return view('finance', ['financeDocument' => $financeDocument]);
    }

    public function indexAdmin()
    {
        $document = FinanceDocuments::all();
        return view('admin/finance', ['document' => $document]);
    }

    public function store(Request $request){
        $request->validate([
            'filePath' => 'required|mimes:pdf|max:10000',
            'year' => 'required',
        ]);
        $newFile = new FinanceDocuments();
        $path = $request->file('filePath')->storeAs(
            'public/files/finance', $request->input('year').".pdf"
        );
        $newFile->year = $request->input('year');
        $newFile->filePath = 'files/finance/'.$request->input('year').".pdf";
        $newFile->save();
        return redirect('/admin/financien')->with('message', 'PDF toegevoegd');
    }

    public function delete(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = FinanceDocuments::find($request->id);
            $tobeDeleted->delete();
            return redirect('admin/financien')->with('information', 'PDF verwijderd');
        } else {
            return redirect('admin/financien');
        }
    }
}
