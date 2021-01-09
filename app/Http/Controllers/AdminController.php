<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use App\Models\Commissie;
use App\Models\Intro;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use DB;

use App\Enums\paymentStatus;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function getUsers()
    {
        $users = DB::table('users')->get();
        return view('admin/leden',['users' => $users]);
    }

    public function dashboard()
    {
        $getAllUsers = AzureUser::all()->count();
        $getAllIntroSignups = Intro::all()->count();
        return view('admin',['userCount' => $getAllUsers, 'introCount' => $getAllIntroSignups]);
    }

    public function getIntro()
    {
        $allIntro = Intro::orderBy('firstName')->with('payment')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
        return view('admin/intro', ['introObjects' => $allIntro]);
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
}
