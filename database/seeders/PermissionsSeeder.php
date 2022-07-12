<?php

namespace Database\Seeders;

use App\Models\Permission;
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

        foreach($arrayPermissions as $permission) {
            $newPermission = new Permission();
            $newPermission->description = $permission;
            $newPermission->save();
        }
    }
}
