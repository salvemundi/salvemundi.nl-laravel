<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use App\Models\WhatsappLink;
use App\Models\Rule;

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

        $transactions = $user->transactions ?? collect();
        $transactions = $transactions->sortByDesc('created_at');

        $subscription = Subscription::where('owner_id', $user->id)->latest()->first();

        $subscriptionActive = false;
        $expiryDate = null;
        if ($subscription) {
            $subscriptionActive = $subscription->isActive();
            $expiryDate = $subscription->cycle_ends_at;
        }

        $whatsapplink = WhatsappLink::all();
        $rules = Rule::all();
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
