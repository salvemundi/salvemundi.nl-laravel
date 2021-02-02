<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return view('admin/products',['products' => Product::all()]);
    }

    public function editPage(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        return view('admin/productEdit', ['product' => Product::find($request->input('id'))]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        $productObject = Product::find($request->input('id'));

        if($productObject->index == null)
        {
            $productObject->name = $request->input('name');
        }
        $productObject->amount = $request->input('price');
        $productObject->description = $request->input('description');
        $productObject->save();
        return redirect('/admin/products');
    }
}
