<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function addSponsor($name,$imgPath,$reference)
    {

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
            return redirect('admin/sponsors');
        } else {
            return redirect('admin/sponsors');
        }
    }
}
