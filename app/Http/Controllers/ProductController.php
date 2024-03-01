<?php
declare(strict_types=1);

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
            'redirect_url' => 'required',
        ]);
        $productObject = Product::find($request->input('id'));

        if($productObject->index == null)
        {
            $productObject->name = $request->input('name');
        }
        $productObject->amount = $request->input('price');
        $productObject->description = $request->input('description');
        $productObject->redirect_url = $request->input('redirect_url');
        $productObject->save();
        return redirect('/admin/products');
    }

    public function delete(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = Product::find($request->id);
            $tobeDeleted->delete();
            return redirect('admin/products')->with('information', 'Product verwijderd');
        } else {
            return redirect('admin/products');
        }
    }
}
