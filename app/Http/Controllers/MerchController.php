<?php

namespace App\Http\Controllers;

use App\Enums\MerchGender;
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
            return back()->with('error','Merch item not found.');
        }
//        dd(json_encode($merch->merchSizes));
        return view('merchSingleProduct',['merch' => $merch,'sizes' => MerchSize::all()]);
    }

    public function adminView(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merch', ['products' => Merch::all()]);
    }

    public function adminEditView(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merchEdit',['merch' => Merch::find($request->id)]);
    }

    public function viewInventory(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $merch = Merch::find($request->id);
        $merchSizes = MerchSize::all();

        return view('admin.merchInventory',['merch' => $merch,'allSizes' => $merchSizes]);
    }

    public function storeSize(Request $request): RedirectResponse
    {
        $merch = Merch::find($request->id);

        $size = $merch->merchSizes->find($request->sizeId);

        if ($request->input('amount') < 0) {
            return back()->with('error', 'Aantal kan niet kleiner dan 0 zijn!');
        }

        $size->pivot->amount = $request->input('amount');
        $size->pivot->save();

        return back()->with('success','Aantal opgeslagen!');
    }

    public function attachSize(Request $request): RedirectResponse
    {
        $merch = Merch::find($request->id);
        $merch->merchSizes()->attach($request->input('size'), ['amount'=> $request->input('amount'),'merch_gender' => MerchGender::coerce((int)$request->input('gender'))->value]);

        return back()->with('success','Inventaris opgeslagen!');
    }

    public function deleteSize(Request $request): RedirectResponse
    {
        $merch = Merch::find($request->id);
        $merch->merchSizes()->detach((int)$request->sizeId);

        return back()->with('success','Inventaris bijgewerkt!');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'filePath' => 'image|mimes:jpeg,png,jpg,svg,webp',
        ]);

        $id = $request->id;

        $merch = Merch::findOrNew($request->id ?? null);
        $merch->name = $request->input('name');
        $merch->description = $request->input('description');
        $merch->price = $request->input('price') ?? 0;
        $merch->discount = $request->input('discount') ?? 0;

        if ($request->hasFile('filePath')) {
            $merch->imgPath = $request->file('filePath')->store('public/merch');
        }

        $merch->save();

        $message = $id ? 'Merch has been updated!' : 'Merch has been created!';

        return redirect('/admin/merch')->with('success', $message);
    }

    public function delete(Request $request): RedirectResponse
    {
        Merch::find($request->id)->delete();

        return back()->with('succes','Merch is verwijderd!');
    }
}
