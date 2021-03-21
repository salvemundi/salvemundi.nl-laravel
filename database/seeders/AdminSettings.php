<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminSetting;

class AdminSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting1 = new AdminSetting();
        $setting1->settingName = 'intro';
        $setting1->save();
        $setting2 = new AdminSetting();
        $setting2->settingName = 'introConfirm';
        $setting2->save();
    }
}
