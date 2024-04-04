<?php

namespace Database\Seeders;

use App\Enums\MerchType;
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
        $sizes += range(25,50);
        foreach($sizes as $size) {
            if(MerchSize::where('size',(string)$size)->first() == null) {
                $newSize = new MerchSize();
                if(gettype($size) == "integer") {
                    $newSize->type = MerchType::shoe;
                } else {
                    $newSize->type = MerchType::generic;
                }
                $newSize->size = (string)$size;
                $newSize->save();
            }
        }
    }
}
