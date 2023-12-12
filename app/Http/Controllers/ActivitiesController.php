<?php

namespace App\Http\Controllers;

use App\Enums\paymentStatus;
use App\Enums\paymentType;
use App\Models\ActivityAssociation;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ActivitiesController extends Controller {


    public function pubcrawl(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::where('isGroupSignup', true)->latest()->first();
        return view('pubcrawl', ['product' => $product]);
    }
    public function addMemberToAcitivty(Request $request): RedirectResponse
    {
        $activity = Product::find($request->activityId);
        $user = User::find($request->input('addUser'));

        $activity->members()->attach($user);
        return back()->with('success',"Gebruiker is toegevoegd aan activiteit");
    }

    public function removeMemberFromActivity(Request $request): RedirectResponse
    {
        $activity = Product::find($request->activityId);
        $user = User::find($request->userId);

        $activity->members()->detach($user);
        return back()->with('success',"Gebruiker is verwijderd van activiteit");
    }

    public function editActivities(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin/activitiesEdit', ['activities' => Product::findOrFail($request->activityId),'tags' => CommitteeTags::all()]);
    }

    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $activities = Product::where("index", null)->orderBy('created_at', 'desc')->get();
        return view('admin/activities', ['activities' => $activities, 'tags' => CommitteeTags::all()]);
    }

    public function getActivities(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Product::with('transactions')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
    }

    public function signupsActivity(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $activity = Product::find($request->activityId);
        $nonMembers = [];

        foreach($activity->transactions as $transaction) {
            if($transaction->paymentStatus == paymentStatus::paid) {
                foreach ($transaction->nonMembers as $signup) {
                    $nonMembers[] = [$signup->email, $signup->name,$transaction->transactionId, $signup->id,$signup->groupId, $signup->association->name];
                }
                if($transaction->email != null && $transaction->email != ""){
                    $userTransaction = [$transaction->email, $transaction->name, $transaction->transactionId];
                    $nonMembers[] = $userTransaction;
                }
            }
        }
        return view('admin/activitiesSignUps',['allMembers' => User::orderBy('FirstName')->orderBy('LastName')->get(), 'activity' => $activity,'users' => $activity->members->unique(), 'userTransactionInfo' => $nonMembers, 'nonMembersFree' => $activity->nonMembers()->get()]);
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
        } else {
            $products = Product::find($request->input('id'));
        }

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
        $products->isGroupSignup = (bool)$request->input('cbxGroup');
        $products->maxTicketOrderAmount = $request->input('maxTicketOrderAmount') ?? 0;
        $products->oneTimeOrder = (bool)$request->input('cbx');
        $products->membersOnly = (bool)$request->input('cbxMembers');
        $products->description = $request->input('description');
        $products->save();
        
        if($request->input('cbxGroup') && $request->input('associationName')) {
            foreach ($request->input('associationName') as $key => $item) {
                $association = ActivityAssociation::firstOrNew(['name' => $item]);
                // If it's a new association, associate it with the product and save it
                if ($association->isDirty()) {
                    $association->product()->associate($products);
                    $association->save();
                }
            }
        }

        if ($request->input('price2') != null || $request->input('price2') != "") {
            $products->amount_non_member = $request->input('price2');
        }

        $products->save();
        $products->tags()->detach();
        if ($request->input('tags') !== null){
            foreach ($request->input('tags') as $key => $item) {
                $products->tags()->attach($item);
            }
        }
        return redirect('admin/activiteiten')->with('message', 'Activiteit gemaakt');
    }

    public function run(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $halfYearAgo = Carbon::now()->subMonths(6);
        $activiteiten = Product::latest()->where('index', null)->whereDate('created_at', '>=', $halfYearAgo)->get();
        $user = Auth::user();
        return view('activities', ['activiteiten' => $activiteiten, 'userIsActive' => $user ? $user->hasActiveSubscription() : false]);
    }

    public static function userHasPayedForActivity($activityId): bool
    {
        $user = null;
        $activity = Product::find($activityId);
        if (Auth::check()) {
            $user = Auth::user();
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
            if($transaction->product != null && $transaction->product->id == $activityId) {
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
            return back()->with('error','Deze activiteit zit helaas al vol!');
        }

        $user = null;
        $groupPrice = null;
        $uuid = null;
        // individual signups
        if (!Auth::check() && !$activity->isGroupSignup)
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
        } else {
            $user = Auth::user();
        }

        // Group signups
        if($activity->isGroupSignup) {
            $user = null;
            if($request->input('amountOfTickets') > $activity->maxTicketOrderAmount) {
                return back()->with('error','Maximum signups per round exceeded');
            }
            $groupPrice = $request->input('amountOfTickets') * $activity->amount;
            $uuid = Str::uuid()->toString();
            if($request->input('amountOfTickets') != 1) {
                $activity->formsLink = route('home');
            }
            foreach ($request->input('participant') as $key => $item) {
                $groupMember = new NonUserActivityParticipant();
                $groupMember->name = $item;
                $groupMember->groupId = $uuid;
                $groupMember->association()->associate(ActivityAssociation::find($request->input('association')));
                $groupMember->activity()->associate($activity)->save();
            }
        }

        return MolliePaymentController::processRegistration($activity, paymentType::activity, $activity->formsLink, null, $user, $request->input('email'), $request->input('nameActivity'),$groupPrice, $uuid);
    }
}
