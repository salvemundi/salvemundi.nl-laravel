<?php

namespace Database\Seeders;

use App\Enums\paymentType;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(paymentType::asArray() as $product => $i)
        {
            $newProduct = new Product();
            $newProduct->name = $product;
            $newProduct->index = $i;
            $newProduct->price = 20.00;
            $newProduct->description = "Test";
            $newProduct->save();
        }
    }
}
