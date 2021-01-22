<?php

namespace App\Http\Controllers;

use App\Models\AzureUser;
use App\Models\Commissie;
use App\Models\Intro;
use App\Models\Transaction;
use App\Models\WhatsappLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use DB;

use App\Enums\paymentStatus;

class AdminController extends Controller
{
    public function index()
    {
        $whatsappLinks = WhatsappLink::all();
        return view('admin/admin');
    }

    public function getUsers()
    {
        $users = DB::table('users')->get();
        return view('admin/leden',['users' => $users]);
    }

    public function dashboard()
    {
        $getAllUsers = AzureUser::all()->count();
        $getAllIntroSignups = Intro::all()->count();
        $whatsappLinks = WhatsappLink::all();
        return view('admin/admin',['userCount' => $getAllUsers, 'introCount' => $getAllIntroSignups, 'whatsappLinks' => $whatsappLinks]);
    }

    public function getIntro()
    {
        $allIntro = Intro::orderBy('firstName')->with('payment')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
        return view('admin/intro', ['introObjects' => $allIntro]);
    }

    public static function authorizeUser($userid): int
    {
        if($userid != null) {
            $groups = AzureUser::where('AzureID', $userid)->first();

            foreach ($groups->commission as $group) {
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc') {
                    return 1;
                }
            }
            return 0;
        } else {
            if(session('id') != null){
                $groups = AzureUser::where('AzureID', session('id'))->first();

                foreach ($groups->commission as $group) {
                    if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc') {
                        return 1;
                    }
                }
                return 0;
            }
            return 401;
        }
    }
    public static function getSponsors()
    {
        return view('admin/sponsors', ['sponsors' => SponsorController::getSponsors()]);
    }

    public function addWhatsappLinks(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:32', 'regex:/^[^(|\\]~@0-9!%^&*=};:?><’)]*$/'],
            'link' => 'required',
            'description' => 'required'
        ]);

        $products = new WhatsappLink;
        $products->name = $request->input('name');
        $products->link = $request->input('link');
        $products->description = $request->input('description');
        $products->save();

        return redirect('admin/')->with('message', 'WhatsApp link gemaakt');
    }

    public function deleteWhatsappLinks(Request $request)
    {
        if($request->id != null) {
            $tobeDeleted = WhatsappLink::find($request->id);
            $tobeDeleted->delete();

            return redirect('admin/')->with('information', 'Link verwijderd');
        } else {
            return redirect('admin/');
        }
    }
}
