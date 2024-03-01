<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function storeRoute(Request $request): RedirectResponse
    {
        if($request->routeId) {
            $route = Route::find($request->routeId);
        } else {
            $route = new Route();
        }
        $route->route = $request->input('route');
        $route->description = $request->input('description');
        $route->save();
        return back()->with('success','Route is opgeslagen!');
    }

    public function deleteRoute(Request $request): RedirectResponse
    {
        if($request->routeId) {
            $route = Route::find($request->routeId);
            $route->delete();
        }
        return back()->with('success','Route is verwijderd!');
    }
}
