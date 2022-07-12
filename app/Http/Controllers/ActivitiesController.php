<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Enums\paymentType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActivitiesController extends Controller {
    public function editActivities(Request $request) {
        $request->validate([
            'id' => ['required'],
        ]);

        return view('admin/activitiesEdit', ['activities' => Product::findOrFail($request->input('id'))]);
    }

    public function index() {
        $activities = Product::where("index", null)->get();
        return view('admin/activities', ['activities' => $activities]);
    }

    public function userIsActive(): bool {
        $sessionId = session('id');

        if ($sessionId === null) {
            return false;
        }

        $userObject       = User::where('AzureID', $sessionId)->firstOrFail();
        $planCommissieLid = paymentType::fromValue(1);
        $plan             = paymentType::fromValue(2);
        $name             = ucfirst($plan) . ' membership';
        $nameCommissieLid = ucfirst($planCommissieLid) . ' membership';

        return $userObject->subscribed($name, $plan->key) || $userObject->subscribed($nameCommissieLid, $planCommissieLid->key);
    }

    public function getActivities() {
        return Product::with('transactions')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
    }

    public function signupsActivity(Request $request){
        $activity = Product::find($request->input('id'));
        $arr = [];
        $userTransactionInfo = [];
        foreach($activity->transactions as $user){
            if($user->paymentStatus == paymentStatus::paid) {
                if($user->email != null || $user->email != "" && $user->name != null || $user->name == ""){
                    array_push($userTransactionInfo, $user->email, $user->name);
                }
                foreach($user->contribution as $uss){
                    array_push($arr,$uss);
                }
            }
        }
        dd($userTransactionInfo);
        return view('admin/activitiesSignUps',['users' => $arr, 'userTransactionInfo' => $userTransactionInfo]);
    }

    private function countSignUps($activityId)
    {
        $activity = Product::find($activityId);
        return $activity->transactions->count();
    }

    public function store(Request $request) {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required',
            'description' => 'required',
            'photo'       => 'image|mimes:jpeg,png,jpg,svg|max:4096'
        ]);

        if ($request->input('id') === null) {
            $products = new Product;

            if ($request->file('photo') !== null) {
                $request->file('photo')->storeAs(
                    'public/activities', $request->input('name') . ".png"
                );

                $products->imgPath = 'activities/' . $request->input('name') . ".png";
            }

            $products->name      = $request->input('name');
            $products->formsLink = $request->input('link');
            $products->amount    = $request->input('price');
            $products->limit     = $request->input('limit');

            if($request->input('cbx')){
                $products->oneTimeOrder = true;
            } else {
                $products->oneTimeOrder = false;
            }

            if ($request->input('cbxMembers')) {
                $products->membersOnly = true;
            } else {
                $products->membersOnly = false;
            }

            if ($request->input('price2') != null || $request->input('price2') != "") {
                $products->amount_non_member = $request->input('price2');
            }

            $products->description = $request->input('description');
            $products->save();
            return redirect('admin/activiteiten')->with('message', 'Activiteit gemaakt');
        }

        $productObject = Product::find($request->input('id'));
        if ($request->file('photo') != null) {
            $path                   = $request->file('photo')->storeAs(
                'public/activities', $request->input('name') . ".png"
            );
            $productObject->imgPath = 'activities/' . $request->input('name') . ".png";
        }

        $productObject->name      = $request->input('name');
        $productObject->formsLink = $request->input('link');
        $productObject->amount    = $request->input('price');
        $productObject->limit     = $request->input('limit');

        if($request->input('cbx')){
            $productObject->oneTimeOrder = true;
        } else {
            $productObject->oneTimeOrder = false;
        }

        if ($request->input('cbxMembers')) {
            $productObject->membersOnly = true;
        } else {
            $productObject->membersOnly = false;
        }

        if ($request->input('price2') != null || $request->input('price2') != "") {
            $productObject->amount_non_member = $request->input('price2');
        }

        $productObject->description = $request->input('description');

        $productObject->save();
        return redirect('admin/activiteiten')->with('message', 'Activiteit is bijgewerkt');
    }

    public function run() {
        $activiteiten = Product::latest()->where('index', null)->get();

        return view('activities', ['activiteiten' => $activiteiten, 'userIsActive' => $this->userIsActive()]);
    }

    public static function userHasPayedForActivity($activityId){
        $user = null;
        $activity = Product::find($activityId);
        if (session('id') !== null) {
            $user = User::where('AzureId', session('id'))->firstOrFail();
        } else {
            return false;
        }
        if($activity != null){
            if(!$activity->oneTimeOrder){
                return false;
            }
        }
        foreach($user->payment as $transaction){
            if($transaction->product->id == $activityId) {
                $status = paymentStatus::coerce($transaction->paymentStatus);
                return $status->is(paymentStatus::paid);
            }
        }
        return false;
    }

    public function deleteActivity(Request $request) {
        if ($request->id !== null) {
            $tobeDeleted = Product::find($request->id);
            $tobeDeleted->delete();
            return redirect('admin/activiteiten')->with('information', 'Activiteit verwijderd');
        } else {
            return redirect('admin/activiteiten');
        }
    }

    public function signup(Request $request): RedirectResponse {
        $user = null;

        if (session('id') !== null) {
            $user = User::where('AzureId', session('id'))->firstOrFail();
        }

        $activity = Product::find($request->input('activityId'));
        if($this->countSignUps($request->input('activityId')) >= $activity->limit && $activity->limit != 0){
            return back();
        }
        return MolliePaymentController::processRegistration($activity, paymentType::activity, $activity->formsLink, null, $user, $request->input('email'), $request->input('nameActivity'));
    }
}
