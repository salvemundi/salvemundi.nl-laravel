<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        $this->call([
            ProductSeeder::class,
            AdminSettings::class,
            ADUsers::class
        ]);

        if (App::isProduction()) {
            $this->call([
                ADUsers::class
            ]);
        }
    }
}
