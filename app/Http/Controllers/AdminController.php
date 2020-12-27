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

    public function show()
    {
        $signins = DB::table('introduction')->get();
        // dd($signins);

        return view('admin',['signins' => $signins]);
    }
    public static function authorizeUser($userid): int
    {
        $groups = AzureUser::where('AzureID', $userid)->first();

        foreach ($groups->commission as $group)
        {
            if($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc')
            {
                return 1;
            }
        }
        return 0;
    }
}
