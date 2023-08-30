<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Enums\paymentType;
use App\Models\CommitteeTags;
use App\Models\NonUserActivityParticipant;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ActivitiesController extends Controller {

    public function addMemberToAcitivty(Request $request) {
        $activity = Product::find($request->activityId);
        $user = User::find($request->input('addUser'));

        $activity->members()->attach($user);
        return back()->with('success',"Gebruiker is toegevoegd aan activiteit");
    }

    public function removeMemberFromActivity(Request $request) {
        $activity = Product::find($request->activityId);
        $user = User::find($request->userId);

        $activity->members()->detach($user);
        return back()->with('success',"Gebruiker is verwijderd van activiteit");
    }

    public function editActivities(Request $request) {
        $request->validate([
            'id' => ['required'],
        ]);
        return view('admin/activitiesEdit', ['activities' => Product::findOrFail($request->input('id')),'tags' => CommitteeTags::all()]);
    }

    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $activities = Product::where("index", null)->orderBy('created_at', 'desc')->get();
        return view('admin/activities', ['activities' => $activities, 'tags' => CommitteeTags::all()]);
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

    public function signupsActivity(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $activity = Product::find($request->activityId);
        $nonMembers = [];
        $members = [];
        foreach($activity->members as $user) {
            $members[] = $user;
        }
        foreach($activity->transactions as $transaction) {
            if($transaction->paymentStatus == paymentStatus::paid) {
                if($transaction->email != null && $transaction->email != ""){
                    $userTransaction = [$transaction->email, $transaction->name, $transaction->transactionId];
                    $nonMembers[] = $userTransaction;
                }
            }
        }
        return view('admin/activitiesSignUps',['allMembers' => User::all(), 'activity' => $activity,'users' => $members, 'userTransactionInfo' => $nonMembers, 'nonMembersFree' => $activity->nonMembers()->get()]);
    }

    private function countSignUps($activityId)
    {
        $activity = Product::find($activityId);
        return $activity->transactions->where('paymentStatus', paymentStatus::paid)->count();
    }

    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
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
            $products->membersOnlyContent = $request->input('membersOnlyContent');
            $products->amount    = $request->input('price');
            $products->limit     = $request->input('limit');
            $products->tags()->detach();
            if ($request->input('tags') !== null){
                foreach ($request->input('tags') as $key => $item) {
                    $products->tags()->attach($item);
                }
            }
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
        $productObject->tags()->detach();
        if ($request->input('tags') !== null){
            foreach ($request->input('tags') as $key => $item) {
                $productObject->tags()->attach($item);
            }
        }

        $productObject->name      = $request->input('name');
        $productObject->formsLink = $request->input('link');
        $productObject->membersOnlyContent = $request->input('membersOnlyContent');
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

    public static function userHasPayedForActivity($activityId): bool
    {
        $user = null;
        $activity = Product::find($activityId);
        if (session('id') !== null) {
            $user = User::where('AzureId', session('id'))->firstOrFail();
            if($user->activities->contains($activity)) {
                return true;
            }
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

    public function signUp(Request $request): RedirectResponse {
        $activity = Product::find($request->input('activityId'));

        if($this->countSignUps($request->input('activityId')) >= $activity->limit && $activity->limit != 0){
            return back();
        }

        $user = null;

        if (session('id') == null)
        {
            if ((!$activity->nonMembers()->where('email', $request->input('email'))->exists() && $activity->oneTimeOrder) || !$activity->oneTimeOrder) {
                $non_member = new NonUserActivityParticipant();
                $non_member->activity()->associate($activity);
                $non_member->name = $request->input('nameActivity');
                $non_member->email = $request->input('email');

                $non_member->save();
            } else {
                return back()->with('message', 'Je kunt je maar één keer aanmelden voor de activiteit: ' . $activity->name . '!');
            }
        }

        return MolliePaymentController::processRegistration($activity, paymentType::activity, $activity->formsLink, null, $user, $request->input('email'), $request->input('nameActivity'));
    }
}
