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
        $committees = Commissie::with('users')->orderBy('DisplayName', 'ASC')->get();
        // dd($committees);

        // sorteer eerst op bestuur, kandi bestuur en dan de rest
        return view('committee.index', ['committees' => $committees]);
    }

    public function committee(Request $request) {
        $committeeName = $request->route('committee_name');
        $committee = Commissie::where('DisplayName', $committeeName)->with('users')->firstOrFail();

        return view('committee.committee', ['committee' => $committee]);
    }
}
