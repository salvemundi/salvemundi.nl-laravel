<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class GetUsersController extends Controller
{

    public function run()
    {


        $membersBestuur = DB::table('users')
                    ->join('groups_relation', 'user_id', '=', 'users.id')
                    ->join('groups', 'groups.id', '=', 'groups_relation.group_id')
                    ->select('users.DisplayName as DisplayName', 'users.ImgPath as Image', 'users.email as email')
                    ->where('groups.AzureID', '=', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')
                    ->get();

        $groups = DB::table('groups')
                    ->where('AzureID', '!=','b16d93c7-42ef-412e-afb3-f6cbe487d0e0')
                    ->get();
        foreach($groups as $commissies)
        {
            $getCommissieMembers = DB::table('users')
                ->join('groups_relation', 'user_id', '=', 'users.id')
                ->join('groups', 'groups.id', '=', 'groups_relation.group_id')
                ->select('users.DisplayName as DisplayName', 'users.ImgPath as Image', 'users.email as email')
                ->where('groups.AzureID', '=', $commissies->AzureID)
                ->get();
        }
        //dd($groups->getProperties());
        return view('users', ['membersBestuur' => $membersBestuur,'']);
    }
}
