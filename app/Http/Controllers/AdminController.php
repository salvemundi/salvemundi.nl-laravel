<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AzureController;
use App\Jobs\AzureSync;
use App\Jobs\DisableAzure;
use App\Jobs\EnableAzure;
use App\Mail\MembershipExpiry;
use App\Models\Commissie;
use App\Models\Intro;
use App\Models\IntroData;
use App\Models\Sponsor;
use App\Models\Transaction;
use App\Models\WhatsappLink;
use App\Models\User;
use App\Models\AdminSetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Enums\paymentType;
use App\Enums\paymentStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $whatsappLinks = WhatsappLink::all();
        return view('admin/admin',['whatsappLinks' => $whatsappLinks]);
    }
    public function Sync(Request $request)
    {
        $response = array();
        echo $response['status'] = 'success';
        AzureSync::dispatch();
    }
    public function dashboard()
    {
        $getAllUsers = User::all()->count();
        $getAllIntroSignups = Intro::orderBy('firstName')->with('payment')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->count();
        $whatsappLinks = WhatsappLink::latest()->first();
        $sponsorsCount = Sponsor::all()->count();
        $transactionCount = Transaction::all()->count();
        $plan = paymentType::fromValue(2);
        $planCommissieLid = paymentType::fromValue(1);
        $name = ucfirst($plan) . ' membership';
        $nameCommissieLid = ucfirst($planCommissieLid) . ' membership';
        $OpenPaymentsCount = 0;
        foreach(User::all() as $user)
        {
            if(!$user->subscribed($name, $plan->key) && !$user->subscribed($nameCommissieLid, $planCommissieLid->key))
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
        $IntroConfirmSetting = AdminSetting::where('settingName','introConfirm')->first();
        $introSignup = IntroData::all();
        $emailsFirstYear = IntroController::sendMailFirstYear();
        $emailsSecondYear = IntroController::sendMailSecondYear();
        $emailNonPaid = IntroController::sendMailNonPaid();
        $emailPaid = IntroController::sendMailPaid();
        $allEmails = IntroController::sendMailToAll();
        //dd($emailsFirstYear, $emailsSecondYear);
        return view('admin/intro', ['allEmails' => $allEmails, 'emailNonPaid' => $emailNonPaid, 'emailPaid' => $emailPaid,'introObjects' => $allIntro,'introSetting' => $IntroSetting,'introConfirmSetting' => $IntroConfirmSetting,'introSignUp' => $introSignup, 'emailsFirstYear' => $emailsFirstYear, 'emailsSecondYear' => $emailsSecondYear]);
    }

    public static function authorizeUser($userid): int
    {
        if($userid != null) {
            $groups = User::where('AzureID', $userid)->first();

            foreach ($groups->commission as $group) {
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                    return 1;
                }
            }
            if($groups->AzureID == "f35114c4-9ccf-4b12-bf66-ab85e7536243" || $groups->AzureID == "e1461535-4e72-400f-bf29-78a598fa75e0" || $groups->AzureID == "5f2bef70-ed28-4a26-95d3-774e0c89d830"){
                return 1;
            }
            return 0;
        } else {
            if(session('id') != null){
                $groups = User::where('AzureID', session('id'))->first();

                foreach ($groups->commission as $group) {
                    if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                        return 1;
                    }
                }
                if($groups->AzureID == "f35114c4-9ccf-4b12-bf66-ab85e7536243" || $groups->AzureID == "e1461535-4e72-400f-bf29-78a598fa75e0" || $groups->AzureID == "5f2bef70-ed28-4a26-95d3-774e0c89d830"){
                    return 1;
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
        return redirect('/admin/intro')->with('information', $message);
    }

    public function storeIntroConfirm(Request $request) {
        $adminConfirmSetting = AdminSetting::where('settingName', 'introConfirm')->first();
        if($request->input('cdx'))
        {
            $adminConfirmSetting->settingValue = 1;
            $message = 'De intro inschrijving met betaling staat nu aan';
        } else {
            $adminConfirmSetting->settingValue = 0;
            $message = 'De intro inschrijving met betaling staat nu uit';
        }
        $adminConfirmSetting->save();
        return redirect('/admin/intro')->with('information', $message);
    }

    public function indexTransaction(){
        $transaction = Transaction::all();
        return view('admin/transaction', ['transactions' => $transaction]);
    }

    public function groupIndex(Request $request)
    {
        $groupUser = User::find($request->input('id'));
        $id = $groupUser->id;
        $groupUsers = $groupUser->commission()->get();
        $groups = Commissie::with('users')->whereDoesntHave('users', function($query) use ($id) {
            $query->where('users.id', $id);
        })->get();
        return view('admin/ledenGroups', ['groupUser' => $groupUsers, 'groups' => $groups, 'userName' => $groupUser]);
    }

    public function groupStore(Request $request)
    {
        $groupUser = User::find($request->input('userId'));
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
        $groupUser = User::find($request->input('userId'));
        $groupObject = Commissie::find($request->input('groupId'));
        $groupUser->commission()->detach($groupObject);
        if(AzureController::removeUserFromGroup($groupUser, $groupObject)) {
            return redirect('/admin/leden/groepen?id='.$groupUser->id)->with('message', 'Lid is verwijderd van de commissie');
        } else {
            return redirect('/admin/leden/groepen?id='.$groupUser->id)->with('message', 'Er is iets mis gegaan probeer het opnieuw of meld het de ICT commissie');
        }
    }

    public function viewRemoveLeden(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userCollectionPaid = Collection::make();
        $userCollectionUnPaid = Collection::make();
        $userObjectList = User::all();
        foreach($userObjectList as $userObject)
        {
            AdminController::authorizeUser(session('id'));
            $planCommissieLid = paymentType::fromValue(1);
            $plan = paymentType::fromValue(2);
            $name = ucfirst($plan) . ' membership';
            $nameCommissieLid = ucfirst($planCommissieLid) . ' membership';
            if($userObject->subscribed($name,$plan->key) || $userObject->subscribed($nameCommissieLid,$planCommissieLid->key))
            {
                $userCollectionPaid->push($userObject);
            } else{
                $userCollectionUnPaid->push($userObject);
            }
        }
        return view('admin/leden',['usersPaid' => $userCollectionPaid, 'usersUnPaid' => $userCollectionUnPaid]);
    }
    public function disableAzureAcc(Request $request) {
        $user = User::find($request->input("id"));
        if($request->input("mode") == "true") {
            AzureController::accountEnabled(true, $user);
        } else{
            AzureController::accountEnabled(false, $user);
        }
        return redirect("/admin/leden");
    }
    public function DisableAllAzureAcc(Request $request){
        $userCollectionPaid = Collection::make();
        $userCollectionUnPaid = Collection::make();
        $userObjectList = User::all();
        foreach($userObjectList as $userObject)
        {
            $planCommissieLid = paymentType::fromValue(1);
            $plan = paymentType::fromValue(2);
            $name = ucfirst($plan) . ' membership';
            $nameCommissieLid = ucfirst($planCommissieLid) . ' membership';
            if($userObject->subscribed($name,$plan->key) || $userObject->subscribed($nameCommissieLid,$planCommissieLid->key))
            {
                $userCollectionPaid->push($userObject);
            } else{
                $userCollectionUnPaid->push($userObject);
            }
        }
        if($request->input("mode") == "true"){
            EnableAzure::dispatch($userCollectionUnPaid);
        } else {
            DisableAzure::dispatch($userCollectionUnPaid);
        }
        return redirect('/admin/leden');
    }

    public function SendEmailToUnpaidMembers(): void
    {
        $userCollection = new Collection();
        foreach (User::all() as $user) {
            if(!$user->hasActiveSubscription()) {
                $userCollection->push($user->email);
                if($user->inschrijving !== null) {
                    $userCollection->push($user->inschrijving->email);
                }
            }
        }
        Mail::bcc($userCollection)->send(new MembershipExpiry());
    }
}
