<?php

namespace Database\Seeders;

use App\Models\Commissie;
use App\Models\Permission;
use App\Models\Route;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayPermissions = ['globalAdmin','activiteiten','ledenAdministratie'];
        $routes = ['*','/admin/activiteiten/*','/admin/activities/*','/admin/leden','/admin'];

        foreach($routes as $route) {
            if(Route::where('route',$route)->first() === null) {
                $newRoute = new Route();
                $newRoute->route = $route;
                $newRoute->save();
            }
        }
        foreach($arrayPermissions as $permission) {
            if(Permission::where('description',$permission)->first() === null) {
                $newPermission = new Permission();
                $newPermission->description = $permission;
                $newPermission->save();
            }
        }

        $permission = Permission::where('description','globalAdmin')->first();
        foreach(Route::all() as $route) {
            $permission->routes()->attach($route);
        }
        $permission->save();

        $permission = Permission::where('description','activiteiten')->first();
        $route = Route::where('route','/admin/activiteiten/*')->first();
        $permission->routes()->attach($route);
        $permission->save();
        $route = Route::where('route','/admin')->first();
        $permission->routes()->attach($route);
        $permission->save();
        $route = Route::where('route','/admin/activities/*')->first();
        $permission->routes()->attach($route);
        $permission->save();

        $committee = Commissie::where('AzureID','a4aeb401-882d-4e1e-90ee-106b7fdb23cc')->first();
        $committee->permissions()->attach(Permission::where('description','globalAdmin')->first());
        $committee->save();
    }
}
