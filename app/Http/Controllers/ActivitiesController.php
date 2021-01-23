<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Product::where('index', null)->get();
        return view('admin/activities', ['activities' => $activities]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        $products = new Product;
        $products->name = $request->input('name');
        $products->amount = $request->input('price');
        $products->description = $request->input('description');
        $products->save();

        return redirect('admin/activiteiten')->with('message', 'Activiteit gemaakt');
    }

    public function run()
    {
        $activiteiten = Product::latest()->where('index', null)->get();
        return view('activities', ['activiteiten' => $activiteiten]);
    }

    public function deleteActivity(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = Product::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/activiteiten')->with('information', 'Activiteit verwijderd');
        } else {
            return redirect('admin/activiteiten');
        }
    }
}
