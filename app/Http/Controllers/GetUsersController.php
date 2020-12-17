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
                    ->select('users.DisplayName as DisplayName', 'users.ImgPath as Image', 'users.email as email','Description', 'groups.DisplayName as groupName')
                    ->where('groups.AzureID', '=', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')
                    ->get();

        $groupsBestuur = DB::table('groups')
                    ->select('id', 'AzureID', 'Description', 'groups.DisplayName as groupName')
                    ->where('AzureID', '=','b16d93c7-42ef-412e-afb3-f6cbe487d0e0')
                    ->get();

        $groups = DB::table('groups')
                    ->select('id', 'AzureID', 'Description', 'DisplayName')
                    ->where('AzureID', '!=','b16d93c7-42ef-412e-afb3-f6cbe487d0e0')
                    ->get();
        $array = array();

        $getCommissieMembers = DB::table('users')
            ->join('groups_relation', 'user_id', '=', 'users.id')
            ->join('groups', 'groups.id', '=', 'groups_relation.group_id')
            ->select('users.DisplayName as DisplayName', 'users.ImgPath as Image', 'users.email as email', 'groups.id as groupID')
            ->get();

        return view('users', ['membersBestuur' => $membersBestuur,'groups' => $groups, 'getCommissieMembers' => $getCommissieMembers, 'groupsBestuur' => $groupsBestuur]);
    }
}
