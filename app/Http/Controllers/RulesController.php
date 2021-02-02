<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rules;

class RulesController extends Controller
{
    public function index(){
        $rules = Rules::all();
        return view('admin/rules',['rules' => $rules]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:32'],
            'link' => 'required',
        ]);

        $rules = new Rules;
        $rules->name = $request->input('name');
        $rules->link = $request->input('link');
        $rules->save();

        return redirect('admin/rules')->with('message', 'Regels link is aangemaakt');
    }

    public function delete(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = Rules::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/rules')->with('information', 'Regels verwijderd');
        } else {
            return redirect('admin/rules');
        }
    }
}
