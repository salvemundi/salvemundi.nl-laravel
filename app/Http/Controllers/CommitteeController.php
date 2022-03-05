<?php

namespace App\Http\Controllers;

use App\Models\Commissie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class CommitteeController extends Controller
{

    public function index() {
        $bestuur = Commissie::where('AzureID', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')->with('users')->first();
        // Only bestuur isn't in the committees
        $allCommitteesExceptBestuur = Commissie::where('AzureID', '!=', 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0')->with('users')->get();
        return view('committee.index', ['allCommitteesExceptBestuur' => $allCommitteesExceptBestuur, 'bestuur' => $bestuur]);
    }

    public function committee(Request $request) {
        $committeeName = $request->route('committee_name');
        $committee = Commissie::where('DisplayName', $committeeName)->with('users')->firstOrFail();

        return view('committee.committee', ['committee' => $committee]);
    }
}
