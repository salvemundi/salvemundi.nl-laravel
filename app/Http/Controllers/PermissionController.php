<?php

namespace App\Http\Controllers;

use App\Models\Commissie;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        $permissions = [];
        foreach(Permission::all() as $permission){
            if(!$user->permissions->contains($permission)){
                array_push($permissions,$permission);
            }
        }
        return collect($permissions);
    }

    private function getPermissionsGroupDoesNotHave(Commissie $commissie): Collection
    {
        $permissions = [];
        foreach(Permission::all() as $permission){
            if(!$commissie->permissions->contains($permission)){
                array_push($permissions,$permission);
            }
        }
        return collect($permissions);
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
}
