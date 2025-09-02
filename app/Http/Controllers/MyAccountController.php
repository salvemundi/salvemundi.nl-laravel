<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\WhatsappLink;
use App\Models\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class MyAccountController extends Controller
{
    private PermissionController $permissionController;

    public function __construct()
    {
        $this->permissionController = new PermissionController();
    }

    public function index(): Factory|Application|View
    {
        $user = Auth::user();

        // Dit is de correcte manier om de transacties te verwerken,
        // zelfs als de gebruiker nog geen transacties heeft.
        $transactions = $user->transactions ?? collect();
        $transactions = $transactions->sortByDesc('created_at');

        // Haal de meest recente abonnement van de gebruiker op.
        $subscription = Subscription::where('owner_id', $user->id)->latest()->first();

        // Bepaal de status en de vervaldatum van het abonnement.
        $subscriptionActive = false;
        $expiryDate = null;
        if ($subscription) {
            $subscriptionActive = $subscription->isActive();
            $expiryDate = $subscription->cycle_ends_at;
        }

        // Haal alle benodigde gegevens op voor de view.
        $whatsapplink = WhatsappLink::all();
        $rules = Rule::all();
        $authorized = false;
        if ($user != null) {
            $authorized = $this->permissionController->checkIfUserIsAdmin($user);
        }

        // Geef alle variabelen door aan de view.
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
