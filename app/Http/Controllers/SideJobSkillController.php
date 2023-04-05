<?php

namespace App\Http\Controllers;

use App\Models\SideJobSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SideJobSkillController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if($request->id == null) {
            $skill = new SideJobSkill();
        } else {
            $skill = SideJobSkill::find($request->id);
        }
        $skill->name = $request->input('skillName');
        $skill->save();
        return back()->with('message','Skill opgeslagen!');
    }
    public function delete(Request $request): RedirectResponse
    {
        $skill = SideJobSkill::findOrFail($request->id);
        $skill->delete();
        return back()->with('message','Skill verwijderd!');
    }
}
