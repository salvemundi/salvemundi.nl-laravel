<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();
        $targetRoute = "/".$request->path();

        if(Auth::check()) {
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
            return back();
        }
        return back();
    }
}
