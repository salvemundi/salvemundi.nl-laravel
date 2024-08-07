<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\MerchGender;
use App\Enums\MerchType;
use App\Models\Merch;
use App\Models\MerchSize;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MerchController extends Controller
{
    public function view(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('merch', ['products' => Merch::all()]);
    }

    public function viewItem(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $merch = Merch::find($request->id);

        if ($merch == null) {
            return back()->with('error', 'Merch item not found.');
        }
        return view('merchSingleProduct', ['merch' => $merch, 'sizes' => MerchSize::where('type',$merch->type)->get()]);
    }

    public function adminView(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merch', ['products' => Merch::all()]);
    }

    public function adminEditView(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merchEdit', ['merch' => Merch::find($request->id)]);
    }

    public function adminAllOrders(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.merchAllOrders', ['allMerch' => Merch::all()]);
    }

    public function pickedUpToggle(Request $request): RedirectResponse
    {
        foreach (Merch::all() as $merch) {
            foreach ($merch->userOrders as $order) {
                if ($order->pivot->id == $request->orderId) {
                    $order->pivot->isPickedUp = !$order->pivot->isPickedUp;
                    $order->pivot->save();
                }
            }
        }
        return back()->with('succes', 'Order status is bijgewerkt!');
    }

    public function viewInventory(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $merch = Merch::find($request->id);
        $merchSizes = MerchSize::all();

        return view('admin.merchInventory', ['merch' => $merch, 'allSizes' => $merchSizes]);
    }

    public function storeSize(Request $request): RedirectResponse
    {
        $merch = Merch::find($request->id);

        if ($request->input('amount') < 0) {
            return back()->with('error', 'Aantal kan niet kleiner dan 0 zijn!');
        }

        $merch->merchSizes()
            ->where('size_id', $request->sizeId)
            ->where('merch_gender', $request->genderId)
            ->update(['amount' => $request->input('amount')]);

        return back()->with('success', 'Aantal opgeslagen!');
    }

    public function attachSize(Request $request): RedirectResponse
    {
        $merch = Merch::find($request->id);
        foreach ($merch->merchSizes as $size) {
            if ($size->id == $request->id && $size->pivot->merch_gender == $request->input('gender')) {
                return back()->with('error', 'Deze maat wordt al bijgehouden voor dit product.');
            }
        }

        $merch->merchSizes()->attach($request->input('size'), ['amount' => $request->input('amount'), 'merch_gender' => MerchGender::coerce((int)$request->input('gender'))->value]);

        return back()->with('success', 'Inventaris opgeslagen!');
    }

    public function deleteSize(Request $request): RedirectResponse
    {
        $merch = Merch::find($request->id);
        $merch->merchSizes()->wherePivot('size_id', (int)$request->sizeId)->wherePivot('merch_gender', (int)$request->genderId)->detach();


        return back()->with('success', 'Inventaris bijgewerkt!');
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
        $merch->type = MerchType::fromValue((int)$request->input('type'))->value ?? 0;
        $merch->price = $request->input('price') ?? 0;
        $merch->discount = $request->input('discount') ?? 0;
        $merch->isPreOrder = $request->input('isPreOrder') ? true : false;
        $merch->canSetNote = $request->input('canSetNote') ? true : false;
        $merch->preOrderNeedsPayment = $request->input('preOrderNeedsPayment') ? true : false;
        $merch->amountPreOrdersBeforeNotification = $request->input('amountPreOrdersBeforeNotification') ?? 0;

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

        return back()->with('succes', 'Merch is verwijderd!');
    }
}
