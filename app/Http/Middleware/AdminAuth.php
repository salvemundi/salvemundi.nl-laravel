<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
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
        $targetRoute = "/".$request->path();
        if($userid != null) {
            $user = User::where('AzureID', $userid)->first();
            $permissions = $user->permissions;
            foreach ($user->commission as $group) {
                foreach($group->permissions as $permission) {
                    $permissions->push($permission);
                }
            }
            foreach($permissions as $permission) {
                foreach($permission->routes as $route) {
                    if(str_contains($route->route,'*')) {
                        if(str_contains($targetRoute, substr($route->route, 0, -2))) {
                            return $next($request);
                        }
                    }
                    if($route->route == $targetRoute || $route->route == '*'){
                        return $next($request);
                    }
                }
            }
            return abort(401);
        }
        return abort(401);
    }
}
