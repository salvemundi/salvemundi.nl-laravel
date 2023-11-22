<?php

namespace App\Http\Controllers;

use App\Models\Merch;
use App\Models\MerchSize;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MerchController extends Controller
{
    public function view(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('merch', ['products' => Merch::all()]);
    }

    public function viewItem(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $merch = Merch::find($request->id);
        if($merch == null) {
            return back()->with('error','Merch item not found');
        }
        return view('merchSingleProduct',['merch' => $merch,'sizes' => MerchSize::all()]);
    }

    public function adminView(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merch', ['products' => Merch::all()]);
    }

    public function viewInventory(Request $request) {
        $merch = Merch::find($request->id);
        $merchSizes = MerchSize::all();
//        dd($merch->merchSizes->first()->pivot->amount);
        return view('admin.merchInventory',['merch' => $merch,'allSizes' => $merchSizes]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'filePath' => 'image|mimes:jpeg,png,jpg,svg,webp',
        ]);
        $merch = Merch::findOrNew($request->id ?? null);
        $merch->name = $request->input('name');
        $merch->description = $request->input('description');
        $merch->price = $request->input('price') ?? 0;
        $merch->discount = $request->input('discount') ?? 0;
        $merch->imgPath = $request->file('filePath')->store('public/merch');
        $merch->save();

        return back()->with('succes','Merch is opgeslagen!');
    }

    public function delete(Request $request): RedirectResponse
    {
        Merch::find($request->id)->delete();
        return back()->with('succes','Merch is verwijderd!');
    }

}
