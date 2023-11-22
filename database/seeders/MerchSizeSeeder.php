<?php

namespace Database\Seeders;

use App\Models\MerchSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['S','M','L','XL','XXL'];
        foreach($sizes as $size) {
            $newSize = new MerchSize();
            $newSize->size = $size;
            $newSize->save();

        }
    }
}
