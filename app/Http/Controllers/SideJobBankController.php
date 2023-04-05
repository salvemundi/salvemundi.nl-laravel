<?php

namespace App\Http\Controllers;

use App\Models\SideJobSkill;
use Illuminate\Http\Request;
use App\Models\SideJobBank;
use App\Enums\StudyProfile;

class SideJobBankController extends Controller
{
    public function editSideJobBank(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        return view('/admin/sideJobBankEdit', ['sideJobSkills' => SideJobSkill::all(),'sideJobBank' => SideJobBank::find($request->input('id')), 'allSideJobBank' => SideJobBank::all()->unique('city')]);
    }

    public function index()
    {
        $viewVar = [];
        $viewVar['minSalary'] = SideJobBank::where('minSalaryEuroBruto','>=',0)->min('minSalaryEuroBruto');
        $viewVar['maxSalary'] = SideJobBank::where('maxSalaryEuroBruto','>=',0)->max('maxSalaryEuroBruto');

        $viewVar['sideJobBank'] = SideJobBank::orderBy('updated_at', 'DESC')->get();

        $viewVar['software'] = SideJobBank::where('studyProfile', Studyprofile::Software)->get();
        $viewVar['technology'] = SideJobBank::where('studyProfile', Studyprofile::Technology)->get();
        $viewVar['infra'] = SideJobBank::where('studyProfile', Studyprofile::Infra)->get();
        $viewVar['business'] = SideJobBank::where('studyProfile', Studyprofile::Business)->get();
        $viewVar['media'] = SideJobBank::where('studyProfile', Studyprofile::Media)->get();

        return view('sidejobbank', $viewVar);
    }

    public function indexAdmin()
    {
        $sideJobBank = SideJobBank::all();
        $sideJobSkills = SideJobSkill::all();
        return view('/admin/sideJobBank', ['sideJobSkills' => $sideJobSkills,'sideJobBank' => $sideJobBank]);
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
            $sideJobBank = $this->setFields($sideJobBank, $request);
            $sideJobBank->save();
            foreach($request->input('skills') as $key => $item) {
                $sideJobBank->skills()->attach($item);
            }
            return redirect('admin/bijbaanbank')->with('message', 'Bijbaan bank  is toegevoegd');
        }
        else
        {
            $sideJobBankObject = SideJobBank::find($request->input('id'));
            $this->setFields($sideJobBankObject, $request)->save();
            $sideJobBankObject->skills()->detach();
            foreach($request->input('skills') as $key => $item) {
                $sideJobBankObject->skills()->attach($item);
            }
            return redirect('admin/bijbaanbank')->with('message', 'Bijbaan bank  is bijgewerkt');
        }

    }

    private function setFields(SideJobBank $sideJobBankObject,Request $request): SideJobBank
    {
        $sideJobBankObject->name = $request->input('name');
        $sideJobBankObject->studyProfile = StudyProfile::coerce((int)$request->input('studyProfile'));
        $sideJobBankObject->description = $request->input('description');
        $sideJobBankObject->city = $request->input('city');
        $sideJobBankObject->minAmountOfHoursPerWeek = $request->input('minimumHours');
        $sideJobBankObject->maxAmountOfHoursPerWeek = $request->input('maximumHours');
        $sideJobBankObject->minSalaryEuroBruto = $request->input('minimumSalary');
        $sideJobBankObject->maxSalaryEuroBruto = $request->input('maximumSalary');
        $sideJobBankObject->linkToJobOffer = $request->input('link');
        $sideJobBankObject->emailContact = $request->input('email');
        $sideJobBankObject->phoneNumberContact = $request->input('phoneNumber');
        $sideJobBankObject->position = $request->input('position');

        return $sideJobBankObject;
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
