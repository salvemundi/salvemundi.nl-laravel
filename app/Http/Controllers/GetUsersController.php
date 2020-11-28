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
        $members = DB::table('users')
                    ->join('groups_relation', 'user_id', '=', 'users.id')
                    ->join('groups', 'groups.id', '=', 'groups_relation.group_id')
                    ->select('users.DisplayName as DisplayName', 'users.ImgPath as Image', 'users.email as email')
                    ->where('groups_relation.group_id', '=', 9)
                    ->get();

        return view('users', ['members' => $members]);
    }
}
