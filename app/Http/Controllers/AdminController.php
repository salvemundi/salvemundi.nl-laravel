<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use App\Models\Commissie;
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
        $signins = DB::table('introduction')->get();
        return view('admin',['signins' => $signins]);
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
