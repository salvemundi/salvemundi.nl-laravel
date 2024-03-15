<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Commissie;
use App\Models\Permission;
use App\Models\Route;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Utils;

class PermissionController extends Controller
{
    private function assignUserPermission(User $user, Permission $permission)
    {
        $user->permissions()->attach($permission);
        $user->save();
    }

    private function removeUserPermission(User $user, Permission $permission)
    {
        $user->permissions()->detach($permission);
        $user->save();
    }


    private function assignGroupPermission(Commissie $commissie, Permission $permission)
    {
        $commissie->permissions()->attach($permission);
        $commissie->save();
    }

    private function removeGroupPermission(Commissie $commissie, Permission $permission)
    {
        $commissie->permissions()->detach($permission);
        $commissie->save();
    }

    public function viewPermissionsUser(Request $request): View|Factory|Application|RedirectResponse
    {
        if($request->userId == null) {
            return back();
        }
        $user = User::find($request->userId);
        return view('admin/ledenPermission', ['user' => $user, 'nonAssignedPermissions' => $this->getPermissionsUserDoesNotHave($user)]);
    }

    public function viewPermissionsGroup(Request $request): View|Factory|Application|RedirectResponse
    {
        if($request->groupId == null) {
            return back();
        }
        $committee = Commissie::find($request->groupId);
        return view('admin/committeePermission', ['committee' => $committee, 'nonAssignedPermissions' => $this->getPermissionsGroupDoesNotHave($committee)]);
    }

    private function getPermissionsUserDoesNotHave(User $user): Collection
    {
        return Permission::all()->diff($user->permissions);
    }

    private function getPermissionsGroupDoesNotHave(Commissie $commissie): Collection
    {
        return Permission::all()->diff($commissie->permissions);
    }

    public function savePermissionUser(Request $request): RedirectResponse
    {
        $user = User::find($request->userId);
        $permission = Permission::find($request->permissionId);
        $this->assignUserPermission($user,$permission);
        return back()->with('success','Rechten succesvol bijgewerkt!');
    }

    public function deletePermissionUser(Request $request): RedirectResponse
    {
        $user = User::find($request->userId);
        $permission = Permission::find($request->permissionId);
        $this->removeUserPermission($user,$permission);
        return back()->with('success','Rechten succesvol bijgewerkt!');
    }

    public function savePermissionGroup(Request $request): RedirectResponse
    {
        $committee = Commissie::find($request->groupId);
        $permission = Permission::find($request->permissionId);
        $this->assignGroupPermission($committee,$permission);
        return back()->with('success','Rechten succesvol bijgewerkt!');
    }

    public function deletePermissionGroup(Request $request): RedirectResponse
    {
        $committee = Commissie::find($request->groupId);
        $permission = Permission::find($request->permissionId);
        $this->removeGroupPermission($committee,$permission);
        return back()->with('success','Rechten succesvol bijgewerkt!');
    }

    public function checkIfUserIsAdmin(User $user): bool
    {
        $allPermissions = $this->getAllPermissionsForUser($user);
        foreach($allPermissions as $permission) {
            foreach($permission->routes as $route) {
                if($route->route == '*' || $route->route == '/admin'){
                    return true;
                }
            }
        }
        return false;
    }

    private function getAllPermissionsForUser(User $user): Collection
    {
        $permissions = [];
        foreach($user->permissions as $permission) {
            array_push($permissions, $permission);
        }
        foreach($user->commission as $group) {
            foreach($group->permissions as $permission) {
                array_push($permissions,$permission);
            }
        }
        return collect($permissions);
    }

    public function viewAllPermissions() {
        return view('admin/permissions',['permissions' => Permission::all(),'routes' => Route::all()]);
    }

    public function storePermission(Request $request): RedirectResponse
    {
        if($request->permissionId) {
            $permission = Permission::find($request->permissionId);
        } else {
            $permission = new Permission();
        }
        $permission->description = $request->input('description');
        $permission->save();
        return back()->with('success','Rechten groep is opgeslagen!');
    }

    public function deletePermission(Request $request): RedirectResponse
    {
        if($request->permissionId) {
            $permission = Permission::find($request->permissionId);
            $permission->delete();
        }
        return back()->with('success','Route is verwijderd!');
    }

    public function viewAllRoutesOfPermission(Request $request): Factory|View|Application
    {
        $permission = Permission::find($request->permissionId);
        return view('admin/permissionsRoute',['permission' => Permission::find($request->permissionId),'routesNotInUse' => $this->getAllRoutesNotInUseByPermission($permission)]);
    }

    private function getAllRoutesNotInUseByPermission(Permission $permissionObj): Collection
    {
        $routes = [];
        foreach(Route::all() as $route){
            if(!$permissionObj->routes->contains($route)){
                array_push($routes,$route);
            }
        }
        return collect($routes);
    }

    public function deleteRouteFromPermission(Request $request) {
        $permission = Permission::find($request->permissionId);
        $route = Route::find($request->routeId);
        $permission->routes()->detach($route);
        $permission->save();
        return back()->with('success','Gegevens opgeslagen!');
    }
    public function addRouteToPermission(Request $request) {
        $permission = Permission::find($request->permissionId);
        $route = Route::find($request->routeId);
        $permission->routes()->attach($route);
        $permission->save();
        return back()->with('success','Gegevens opgeslagen!');
    }
}
