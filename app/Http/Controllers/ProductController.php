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
            'description' => 'required'
        ]);
    }
}
