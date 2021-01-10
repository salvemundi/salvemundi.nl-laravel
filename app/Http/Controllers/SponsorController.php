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
}
