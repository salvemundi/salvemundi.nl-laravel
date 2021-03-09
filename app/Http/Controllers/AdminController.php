<?php

namespace App\Http\Controllers;

use App\Jobs\AzureSync;
use App\Models\AzureUser;
use App\Models\Commissie;
use App\Models\Intro;
use App\Models\Sponsor;
use App\Models\Transaction;
use App\Models\WhatsappLink;
use App\Models\User;
use App\Models\AdminSetting;
use App\Http\Controllers\AzureController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use App\Enums\paymentType;
use App\Enums\paymentStatus;


class AdminController extends Controller
{
    public function index()
    {
        $whatsappLinks = WhatsappLink::all();
        return view('admin/admin',['whatsappLinks' => $whatsappLinks]);
    }

    public function getUsers()
    {
        return view('admin/leden',['users' => User::all()]);
    }
    public function Sync(Request $request)
    {
        $response = array();
        echo $response['status'] = 'success';
        AzureSync::dispatch();
    }
    public function dashboard()
    {
        $getAllUsers = AzureUser::all()->count();
        $getAllIntroSignups = Intro::all()->count();
        $whatsappLinks = WhatsappLink::latest()->first();
        $sponsorsCount = Sponsor::all()->count();
        $transactionCount = Transaction::all()->count();
        $plan = paymentType::fromValue(3);
        $name = ucfirst($plan) . ' membership';
        $OpenPaymentsCount = 0;
        foreach(User::all() as $user)
        {
            if(!$user->subscribed($name, $plan->key))
            {
                $OpenPaymentsCount += 1;
            }
        }
        return view('admin/admin',['userCount' => $getAllUsers, 'introCount' => $getAllIntroSignups, 'whatsappLinks' => $whatsappLinks, 'sponsorsCount' => $sponsorsCount, 'transactionCount' => $transactionCount, 'OpenPaymentsCount' => $OpenPaymentsCount]);
    }

    public function getIntro()
    {
        $allIntro = Intro::orderBy('firstName')->with('payment')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
        $IntroSetting = AdminSetting::where('settingName','intro')->first();

        return view('admin/intro', ['introObjects' => $allIntro,'introSetting' => $IntroSetting]);
    }

    public static function authorizeUser($userid): int
    {
        if($userid != null) {
            $groups = AzureUser::where('AzureID', $userid)->first();

            foreach ($groups->commission as $group) {
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                    return 1;
                }
            }
            return 0;
        } else {
            if(session('id') != null){
                $groups = AzureUser::where('AzureID', session('id'))->first();

                foreach ($groups->commission as $group) {
                    if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                        return 1;
                    }
                }
                return 0;
            }
            return 401;
        }
    }

    public static function getSponsors()
    {
        return view('admin/sponsors', ['sponsors' => SponsorController::getSponsors()]);
    }

    public function storeIntro(Request $request)
    {
        $adminSetting = AdminSetting::where('settingName', 'intro')->first();
        if($request->input('cbx'))
        {
            $adminSetting->settingValue = 1;
            $message = 'De intro inschrijving staat nu aan';
        } else {
            $adminSetting->settingValue = 0;
            $message = 'De intro inschrijving staat nu uit';
        }
        $adminSetting->save();
        return redirect('/admin/intro')->with('message', $message);
    }

    public function indexTransaction(){
        $transaction = Transaction::all();
        return view('admin/transaction', ['transactions' => $transaction]);
    }

    public function groupIndex(Request $request)
    {
        $groupUser = AzureUser::find($request->input('id'));
        $id = $groupUser->id;
        $groupUsers = $groupUser->commission()->get();
        $groups = Commissie::with('users')->whereDoesntHave('users', function($query) use ($id) {
            $query->where('users.id', $id);
        })->get();
        return view('admin/ledenGroups', ['groupUser' => $groupUsers, 'groups' => $groups, 'userName' => $groupUser]);
    }

    public function groupStore(Request $request)
    {
        $groupUser = AzureUser::find($request->input('userId'));
        $groupObject = Commissie::find($request->input('groupId'));
        $groupUser->commission()->attach($groupObject);
        if(AzureController::addUserToGroup($groupUser, $groupObject))
        {
            return redirect('/admin/leden/groepen?id='.$groupUser->id)->with('message', 'Lid is toegevoegd aan de commissie');
            //return $this->groupIndex($request)->with('message', 'Lid is toegevoegd aan de commissie');
        }
        else{
            return redirect('/admin/leden/groepen?id='.$groupUser->id)->with('message', 'Er is iets mis gegaan probeer het opnieuw of meld het de ICT commissie');
        }
    }

    public function groupDelete(Request $request)
    {
        $groupUser = AzureUser::find($request->input('userId'));
        $groupObject = Commissie::find($request->input('groupId'));
        $groupUser->commission()->detach($groupObject);
        if(AzureController::removeUserFromGroup($groupUser, $groupObject)) {
            return redirect('/admin/leden/groepen?id='.$groupUser->id)->with('message', 'Lid is verwijderd van de commissie');
        } else {
            return redirect('/admin/leden/groepen?id='.$groupUser->id)->with('message', 'Er is iets mis gegaan probeer het opnieuw of meld het de ICT commissie');
        }
    }
}
