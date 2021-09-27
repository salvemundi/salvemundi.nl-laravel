<?php

namespace App\Http\Controllers;

use App\Models\Commissie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class GetUsersController extends Controller
{
    public function run()
    {
        $bestuur = Commissie::where('AzureID', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')->with('users')->first();
        $kandiBestuur = Commissie::where('AzureID', 'adf4d258-a404-4bc0-ae73-6bfa429a1537')->with('users')->first();
        $groups = Commissie::where('AzureID', '!=', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')->where('AzureID', '!=','adf4d258-a404-4bc0-ae73-6bfa429a1537')->with('users')->get();
        return view('users', ['groups' => $groups, 'groupsBestuur' => $bestuur, 'kandiBestuur' => $kandiBestuur]);
    }
}
