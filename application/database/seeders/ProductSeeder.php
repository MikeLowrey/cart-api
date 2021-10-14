<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
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
        for ($i = 0; $i < 20; $i++) {
            Product::factory()->create();
            ProductImage::factory()->create([
                'product_id' => $i + 1,
            ]);
        }

        $p = Product::create([
            'name' => 'Test',
            'description' => 'test lorem ipsum',
            'price' => 9999,
        ]);
        ProductImage::factory()->create([
            'product_id' => $p->id,
        ]);
    }
}
