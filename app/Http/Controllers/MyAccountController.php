<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\Models\Subscription; // <-- Deze regel is toegevoegd om de 'Class not found' fout te verhelpen.

class MyAccountController extends Controller // <-- 'AuthController' is gewijzigd in 'MyAccountController'.
{
    private PermissionController $permissionController;

    public function __construct()
    {
        $this->permissionController = new PermissionController();
    }

    public function index(): Factory|Application|View|Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $adminAuthorization = $this->permissionController->checkIfUserIsAdmin($user);

        // Haal de meest recente abonnement van de gebruiker op.
        $subscription = Subscription::where('owner_id', $user->id)->latest()->first();

        // Bepaal de status en de vervaldatum op basis van ons eigen Subscription model.
        // Dit vervangt de onbetrouwbare Cashier check.
        $subscriptionActive = false;
        $expiryDate = null;
        if ($subscription) {
            $subscriptionActive = $subscription->isActive();
            $expiryDate = $subscription->cycle_ends_at;
        }

        $transactions = $user->transactions->sortByDesc('created_at');
        $whatsapplink = WhatsappLink::all();
        $rules = Rule::all();
        $user = Auth::user();
        $authorized = false;
        if ($user != null) {
            $authorized = $this->permissionController->checkIfUserIsAdmin($user);
        }

        return view('mijnAccount', [
            'authorized' => $authorized,
            'user' => $user,
            'transactions' => $transactions,
            'whatsapplink' => $whatsapplink,
            'rules' => $rules,
            'subscriptionActive' => $subscriptionActive,
            'expiryDate' => $expiryDate
        ]);
    }
}
