<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\SideJobBank;
use App\Enums\StudyProfile;

class SideJobBankController extends Controller
{
    public function editSideJobBank(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        return view('/admin/sideJobBankEdit', ['sideJobBank' => SideJobBank::find($request->input('id'))]);
    }

    public function index()
    {
        $viewVar = [];

        $viewVar['sideJobBank'] = SideJobBank::orderBy('updated_at', 'DESC')->get();

        $viewVar['software'] = SideJobBank::where('studyProfile', Studyprofile::Software)->get();
        $viewVar['technology'] = SideJobBank::where('studyProfile', Studyprofile::Technology)->get();
        $viewVar['infra'] = SideJobBank::where('studyProfile', Studyprofile::Infra)->get();
        $viewVar['business'] = SideJobBank::where('studyProfile', Studyprofile::Business)->get();
        $viewVar['media'] = SideJobBank::where('studyProfile', Studyprofile::Media)->get();

        return view('/sidejobbank', $viewVar);
    }

    public function indexAdmin()
    {
        $sideJobBank = SideJobBank::all();
        return view('/admin/sidejobbank', ['sideJobBank' => $sideJobBank]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'studyProfile'  => 'required',
            'description'   => 'required'
        ]);

        if($request->input('id') == null)
        {
            $sideJobBank = new SideJobBank;
            $sideJobBank->name = $request->input('name');
            $sideJobBank->studyProfile = StudyProfile::coerce((int)$request->input('studyProfile'));
            $sideJobBank->description = $request->input('description');
            // dd($sideJobBank);
            $sideJobBank->save();

            return redirect('admin/bijbaanbank')->with('message', 'Bijbaan bank  is toegevoegd');
        }
        else
        {
            $sideJobBankObject = SideJobBank::find($request->input('id'));
            $sideJobBankObject->name = $request->input('name');
            $sideJobBankObject->studyProfile = StudyProfile::coerce((int)$request->input('studyProfile'));
            $sideJobBankObject->description = $request->input('description');
            $sideJobBankObject->save();
            return redirect('admin/bijbaanbank')->with('message', 'Bijbaan bank  is bijgwerkt');
        }
    }

    public function deleteSideJobBank(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = SideJobBank::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/bijbaanbank')->with('information', 'Bijbaan bank verwijderd');
        } else {
            return redirect('admin/bijbaanbank');
        }
    }
}
