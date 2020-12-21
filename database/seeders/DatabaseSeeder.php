<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
Use Database\Seeders\ADUsers;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           ADUsers::class,
        ]);
    }
}
