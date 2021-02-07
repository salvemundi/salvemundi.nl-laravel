<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\AzureUser;
use App\Models\Transaction;
use App\Enums\paymentStatus;

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
            'description' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $products = new Product;
        if($request->file('photo') != null)
        {
            $path = $request->file('photo')->storeAs(
                'public/activities', $request->input('name').".png"
            );
            $products->imgPath = 'activities/'.$request->input('name').".png";
        }

        $products->name = $request->input('name');
        $products->formsLink = $request->input('link');
        $products->amount = $request->input('price');
        $products->description = $request->input('description');
        //dd($products);
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
// Signup method incase board wants payment for activity via mollie
//     public function signup(Request $request)
//     {
//         $getProduct = Product::find($request->input('productId'));
//         $getUser = AzureUser::where('AzureID', session('id'))->first();
//         if($getProduct->amount > 0) {
//             Log::info('Product is not free');
//             return MolliePaymentController::processRegistration($getUser,$getProduct->id,'myAccount');
//         } else {
//             Log::info('Product is free');
//             $newTransaction = new Transaction;
//             $newTransaction->product()->associate($getProduct);
//             $newTransaction->save();
//             $newTransaction->contribution()->attach($getUser);
//             $newTransaction->paymentStatus = paymentStatus::paid;
//             $newTransaction->save();
//             return redirect('/activiteiten')->with('message','Je inschrijving was succesvol.');
//         }
//     }
}
