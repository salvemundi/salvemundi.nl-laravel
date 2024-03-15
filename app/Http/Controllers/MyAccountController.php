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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
        $plan = paymentType::fromValue(2);
        $planCommissieLid = paymentType::fromValue(1);

        $status = $user->subscribed(ucfirst(strval($plan->value)) . ' membership', $plan->key)
        || $user->subscribed(ucfirst(strval($planCommissieLid)) . ' membership', $planCommissieLid->key)
            ? 1 : 0;

        $expiryDate = Subscription::where('owner_id', $user->id)->latest()->first()?->cycle_ends_at;

        return view('mijnAccount', [
            'user' => $user,
            'authorized' => $this->permissionController->checkIfUserIsAdmin($user),
            'whatsapplink' => WhatsappLink::all(),
            'subscriptionActive' => $status,
            'transactions' => $user->payment()->withTrashed()->get(),
            'rules' => Rules::all(),
            'expiryDate' => $expiryDate
        ]);
    }

    public function deletePicture(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $loggedInUser = Auth::user()->update(['ImgPath' => "images/logo.svg"]);

        if (!AzureController::updateProfilePhoto($loggedInUser)) {
            return redirect('/mijnAccount')->with('message', 'Er is iets fout gegaan met het bijwerken van je foto op Office365, probeer het later opnieuw');
        }

        return redirect('/mijnAccount')->with('message', 'Je instellingen zijn bijgewerkt.');
    }

    public function savePreferences(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg|max:20480',
            'minecraft' => 'regex:/^[a-zA-Z0-9_]{3,16}$/'
        ]);

        $user = User::find($request->input('user_id'));

        $user->visibility = $request->input('cbx') ? 1 : 0;
        $user->birthday = $request->input('birthday') ? date("Y-m-d", strtotime($request->input('birthday'))) : $user->birthday;
        $user->PhoneNumber = $request->input('phoneNumber') ?? $user->PhoneNumber;
        $user->minecraftUsername = $request->input('minecraft') ?? $user->minecraftUsername;

        if ($request->file('photo') != null) {
            $request->file('photo')->storeAs('public/users/',$user->AzureID);
            $user->ImgPath = 'users/'.$user->AzureID;

            if (!AzureController::updateProfilePhoto($user)) {
                return redirect('/mijnAccount')->with('message', 'Er is iets fout gegaan met het bijwerken van je foto op Office365, probeer het later opnieuw.');
            }
        }

        $user->save();

        return redirect('/mijnAccount')->with('message', 'Je instellingen zijn bijgewerkt.');
    }
}
