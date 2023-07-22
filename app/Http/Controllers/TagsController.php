<?php

namespace App\Http\Controllers;

use App\Models\CommitteeTags;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function getTags(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin/activityTags',['tags' => CommitteeTags::all()]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $tag = CommitteeTags::find($request->tagId);
        if($tag != null) {
            $tag->delete();
        }
        return back()->with('Deleted tag');
    }

    public function store(Request $request): RedirectResponse
    {
        $tag = CommitteeTags::find($request->tagId);
        if($tag == null)
        {
            $tag = new CommitteeTags();
        }
        $tag->name = $request->input('tagName');
        $tag->icon = $request->input('tagIcon');
        $tag->colorClass = $request->input('tagColorClass');
        $tag->save();
        return back()->with('Data saved succesfully');
    }
}
