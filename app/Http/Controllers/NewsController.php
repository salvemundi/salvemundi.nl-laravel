<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\News;

class NewsController extends Controller
{
    public function editNews(Request $request){
        $request->validate([
            'id' => ['required'],
        ]);

        return view('admin/newsEdit', ['news' => News::find($request->input('id'))]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,svg|max:4096',
            'content' => 'required',
        ]);
        if($request->input('id') == null)
        {
            $news = new News;
            if($request->file('photo') != null)
            {
                $path = $request->file('photo')->storeAs(
                    'public/news', $request->input('title').".png"
                );
            }
            $news->title = $request->input('title');
            $news->content = $request->input('content');
            if($request->file('photo') != null)
            {
                $news->imgPath = 'news/'.$request->input('title').".png";
            }
            $news->save();
            return redirect('admin/nieuws')->with('message', 'Nieuws is toegevoegd');
        }
        else
        {
            $newsObject = News::find($request->input('id'));
            if($request->file('photo') != null)
            {
                $path = $request->file('photo')->storeAs(
                    'public/news', $request->input('title').".png"
                );
            }
            $newsObject->title = $request->input('title');
            $newsObject->content = $request->input('content');
            if($request->file('photo') != null)
            {
                $newsObject->imgPath = 'news/'.$request->input('title').".png";
            }
            $newsObject->save();
            return redirect('admin/nieuws')->with('message', 'Nieuws is bijgwerkt');
        }
    }

    public function index()
    {
        $news = News::orderBy('updated_at', 'DESC')->get();
        $newsCount = News::all()->count();
        return view('/news', ['news' => $news, 'newsCount' => $newsCount]);
    }

    public function indexAdmin()
    {
        $news = News::all();
        return view('/admin/news', ['news' => $news]);
    }

    public function deleteNews(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = News::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/nieuws')->with('information', 'Nieuws verwijderd');
        } else {
            return redirect('admin/nieuws');
        }
    }
}
