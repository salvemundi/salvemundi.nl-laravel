<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminActiviteiten
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = session('id');

        if($userId != null) {
            $user = User::where('AzureID', $userId)->first();

            foreach ($user->commission as $group) {
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                    return $next($request);
                }
            }

            if($user->AzureID == "5f2bef70-ed28-4a26-95d3-774e0c89d830") {
                return $next($request);
            }
            return abort(401);
        }
        return abort(401);
    }
}
