<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
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
    public function authorizeUser($userid)
    {
        $user = AzureUser::where('AzureID', $userid)->commissie()->where('AzureID', 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc')->first();

        if($user->firstName != null)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
}
