<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsible;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements Responsible
{
    public function toResponse($request): RedirectResponse
    {
        // change this to your desired route
        return redirect()->route('home');
    }
}