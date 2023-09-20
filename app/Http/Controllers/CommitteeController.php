<?php

namespace App\Http\Controllers;

use App\Models\Commissie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class CommitteeController extends Controller
{
    private  AzureController $azureController;
    public function __construct() {
        $this->azureController = new  AzureController();
    }
    public function index() {
        $bestuur = Commissie::where('AzureID', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')->with('users')->first();
        // Only bestuur isn't in the committees
        $allCommitteesExceptBestuur = Commissie::where('AzureID', '!=', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')->with('users')->get();
        return view('committee.index', ['allCommitteesExceptBestuur' => $allCommitteesExceptBestuur, 'bestuur' => $bestuur]);
    }

    public function viewMembersGroup(Request $request) {
        $committee = Commissie::find($request->groupId);
        return view('admin.committeeMembers', ['committee' => $committee]);
    }

    public function makeUserCommitteeLeader(Request $request){
        $committee = Commissie::find($request->groupId);
        if ($committee) {
            foreach ($committee->users as $user) {
                if($user->pivot->isCommitteeLeader) {
                    $this->azureController->removeUserFromGroup($user, null, "91d77972-2695-4b7b-a0a0-df7d6523a087");
                }
                $committee->users()->updateExistingPivot($user->id, ['isCommitteeLeader' => false]);
            }
        }
        $user = $committee->users()->find($request->userId);
        if ($user) {
            $this->azureController->addUserToGroup($user, null, "91d77972-2695-4b7b-a0a0-df7d6523a087");
            $user->pivot->isCommitteeLeader = true;
            $user->pivot->save();
        }
        return back()->with('success', 'Nieuwe commissieleider ingesteld!');
    }

    public function committee(Request $request) {
        $committeeName = $request->route('committee_name');
        $committee = Commissie::where('DisplayName', $committeeName)->with('users')->firstOrFail();

        return view('committee.committee', ['committee' => $committee]);
    }
    public function showAllCommitteesAdmin() {
        return view('admin/committees',["committees" => Commissie::all()]);
    }
}
