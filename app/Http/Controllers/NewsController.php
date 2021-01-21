<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\News;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'content' => 'required',
        ]);
        $news = new News;
        $path = $request->file('photo')->storeAs(
            'public/news', $request->input('title').".png"
        );
        $news->title = $request->input('title');
        $news->content = $request->input('content');
        $news->imgPath = 'news/'.$request->input('title').".png";
        $news->save();
        return redirect('admin/news')->with('message', 'Nieubws is toegevoegd');
    }

    public function index()
    {
        $news = News::all();
        return view('/news', ['news' => $news]);
    }

    public function indexAdmin()
    {
        return view('/admin/news');
    }
}
