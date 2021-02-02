<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function addSponsor(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'reference' => 'required',
            'name' => 'required',
        ]);
        $newSponsor = new Sponsor();
        $path = $request->file('photo')->storeAs(
            'public/images/sponsors', $request->input('name').".png"
        );
        $newSponsor->reference = $request->input('reference');
        $newSponsor->name = $request->input('name');
        $newSponsor->imagePath = 'images/sponsors/'.$request->input('name').".png";
        $newSponsor->save();
        return redirect('admin/sponsors/')->with('message', 'Sponsor is toegevoegd');
    }

    public static function getSponsors()
    {
        return Sponsor::all();
    }

    public function deleteSponsor(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = Sponsor::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/sponsors')->with('information', 'Sponsor is verwijderd');
        } else {
            return redirect('admin/sponsors');
        }
    }
}
