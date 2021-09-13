<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Enums\paymentType;
use App\Http\Controllers\MolliePaymentController;
use App\Models\User;

class ActivitiesController extends Controller
{
    public function editActivities(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);
        return view('admin/activitiesEdit', ['activities' => Product::find($request->input('id'))]);
    }

    public function index()
    {
        $activities = Product::where('index', null)->get();
        return view('admin/activities', ['activities' => $activities]);
    }

    public function signupsActivity(Request $request){
        $activity = Product::find($request->input('id'));
        $arr = [];
        foreach($activity->transactions as $user){
            foreach($user->contribution as $uss){
                array_push($arr,$uss);
            }
        }

        return view('admin/activitiesSignUps',['users' => $arr]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if($request->input('id') == null)
        {
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

            if($request->input('price2') != null || $request->input('price2') != ""){
                $products->amount_non_member = $request->input('price2');
            }

            $products->description = $request->input('description');
            //dd($products);
            $products->save();
            return redirect('admin/activiteiten')->with('message', 'Activiteit gemaakt');
        }
        else
        {
            $productObject = Product::find($request->input('id'));
            if($request->file('photo') != null)
            {
                $path = $request->file('photo')->storeAs(
                    'public/activities', $request->input('name').".png"
                );
                $productObject->imgPath = 'activities/'.$request->input('name').".png";
            }

            $productObject->name = $request->input('name');
            $productObject->formsLink = $request->input('link');
            $productObject->amount = $request->input('price');
            $productObject->description = $request->input('description');
            //dd($products);
            $productObject->save();
            return redirect('admin/activiteiten')->with('message', 'Activiteit is bijgewerkt');
        }
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

    public function signup(Request $request){
        $user = null;
        if(session('id') != null){
            $user = User::where('AzureId', $request->input('id'))->first();
        }
        $activity = Product::find($request->input('activityId'));

        return MolliePaymentController::processRegistration($activity, paymentType::activity, null, null, $user);
    }
}
