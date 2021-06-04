<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminIntroAuth
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
        $userid = session('id');

        if($userid != null) {
            $groups = User::where('AzureID', $userid)->first();

            foreach ($groups->commission as $group) {
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                    return $next($request);
                }

            }
            if($groups->AzureID == "f35114c4-9ccf-4b12-bf66-ab85e7536243" || $groups->AzureID == "e1461535-4e72-400f-bf29-78a598fa75e0"){
                return $next($request);
            }
            return abort(401);
        }
        return abort(401);
    }
}
