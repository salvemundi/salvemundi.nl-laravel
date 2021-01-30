<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use App\Models\Commissie;
use App\Models\Intro;
use App\Models\Sponsor;
use App\Models\Transaction;
use App\Models\WhatsappLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Enums\paymentType;

use App\Enums\paymentStatus;
use App\Models\AdminSetting;

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
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc') {
                    return 1;
                }
            }
            return 0;
        } else {
            if(session('id') != null){
                $groups = AzureUser::where('AzureID', session('id'))->first();

                foreach ($groups->commission as $group) {
                    if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc') {
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
        } else {
            $adminSetting->settingValue = 0;
        }
        $adminSetting->save();
        return redirect('/admin/intro');
    }

    public function indexTransaction(){
        $transaction = Transaction::all();
        return view('admin/transaction', ['transactions' => $transaction]);
    }
}
