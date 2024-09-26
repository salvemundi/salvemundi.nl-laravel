<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SafeHavenController extends Controller
{
    public function index(): Factory|View|Application
    {
        $safeHavens = User::where('is_safe_haven', true)->get();

        return view('safehavens', ['safeHavens' => $safeHavens]);
    }

    public  function toggleSafeHaven(Request $request): RedirectResponse
    {
        $user = User::find($request->id);
        $user->is_safe_haven = !$user->is_safe_haven;
        $user->save();
        return redirect()->back();
    }
}
