<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupons', ['coupons' => Coupon::all()]);
    }

    public function delete(Request $request)
    {
        $coupon = Coupon::find($request->id);
        $coupon->delete();
        return back()->with('succes','Coupon is verwijderd!');
    }
    public function apiStore(Request $request)
    {
        $coupon = $this->mapValues($request);
        $coupon->save();
        return response(null, 200);
    }
    public function store(Request $request)
    {
        $coupon = $this->mapValues($request);
        $coupon->save();
        return back()->with('success','Coupon is aangemaakt!');
    }

    public function editView(Request $request) {
        return view('admin.couponsEdit', ['coupon' => Coupon::find($request->id)]);
    }

    private function mapValues(Request $request)
    {
        $coupon = new Coupon;
        if($request->id) {
            $coupon = Coupon::findOrFail($request->id);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'isOneTimeUse' => 'required',
        ]);

        $coupon->name = $request->input('name');
        $coupon->description = $request->input('description');
        $coupon->value = $request->input('price');
        $coupon->currency = $request->input('valuta');
        $coupon->isOneTimeUse = $request->input('isOneTimeUse');

        return $coupon;
    }
}
