<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WhatsappLink;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Rules;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Carbon\Carbon;
use App\Enums\paymentType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Subscription;

class MyAccountController extends Controller
{
    private PermissionController $permissionController;

    public function __construct() {
        $this->permissionController = new PermissionController();
    }

    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $adminAuthorization = $this->permissionController->checkIfUserIsAdmin($user);
        
        // Haal de meest recente abonnement van de gebruiker op.
        $subscription = \App\Models\Subscription::where('owner_id', $user->id)->latest()->first();

        // Bepaal de status en de vervaldatum op basis van ons eigen Subscription model.
        // Dit vervangt de onbetrouwbare Cashier check.
        $subscriptionActive = false;
        $expiryDate = null;
        if ($subscription) {
            $subscriptionActive = $subscription->isActive();
            $expiryDate = $subscription->cycle_ends_at;
        }

        $whatsappLinks = WhatsappLink::all();
        $rules = Rules::all();

        return view('mijnAccount', [
            'user' => $user,
            'authorized' => $adminAuthorization,
            'whatsapplink' => $whatsappLinks,
            'subscriptionActive' => $subscriptionActive, // Gebruik de correct berekende status
            'transactions' => $user->payment()->withTrashed()->get(),
            'rules' => $rules,
            'expiryDate' => $expiryDate
        ]);
    }

    public function deletePicture() {
        $loggedInUser = Auth::user();
        $loggedInUser->ImgPath = "images/logo.svg";
        $loggedInUser->save();

        if (!AzureController::updateProfilePhoto($loggedInUser)) {
            return redirect('/mijnAccount')->with('message', 'Er is iets fout gegaan met het bijwerken van je foto op Office365, probeer het later opnieuw');
        }

        $message = 'Je instellingen zijn bijgewerkt.';

        return redirect('/mijnAccount')->with('message', $message);
    }

    public function savePreferences(Request $request) {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg|max:20480',
            'minecraft' => 'regex:/^[a-zA-Z0-9_]{3,16}$/'
        ]);

        $user = User::find($request->input('user_id'));

        if ($request->input('cbx')) {
            $user->visibility = 1;
            $message = 'Je bent nu te zien op de website';
        }
        else {
            $user->visibility = 0;
            $message = 'Je bent nu niet meer te zien op de website';
        }
        $user->save();

        if ($request->input('birthday') != null) {
            $user->birthday = $request->input('birthday');
            $user->birthday = date("Y-m-d", strtotime($user->birthday));
        }
        $user->save();

        if ($request->input('phoneNumber') != null) {
            $user->PhoneNumber = $request->input('phoneNumber');
        }
        $user->save();

        if($request->input('minecraft') != null) {
            $user->minecraftUsername = $request->input('minecraft');
        }


        if ($request->file('photo') != null) {
            $request->file('photo')->storeAs('public/users/',$user->AzureID);
            $user->ImgPath = 'users/'.$user->AzureID;

            if (!AzureController::updateProfilePhoto($user)) {
                return redirect('/mijnAccount')->with('message', 'Er is iets fout gegaan met het bijwerken van je foto op Office365, probeer het later opnieuw.');
            }
        }
        $user->save();

        $message = 'Je instellingen zijn bijgewerkt.';

        return redirect('/mijnAccount')->with('message', $message);
    }
}
