<?php

namespace App\Http\Middleware;

use App\Models\AzureUser;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
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
            $groups = AzureUser::where('AzureID', $userid)->first();

            foreach ($groups->commission as $group) {
                if ($group->AzureID == 'a4aeb401-882d-4e1e-90ee-106b7fdb23cc' || $group->AzureID == 'b16d93c7-42ef-412e-afb3-f6cbe487d0e0') {
                    return $next($request);
                }
            }
            return abort(401);
        }
        return abort(401);
    }
}
