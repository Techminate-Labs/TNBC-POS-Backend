<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'category_id' => '1',
            'brand_id' => '1',
            'unit_id' => '1',
            'supplier_id' => '1',
            'name' => 'Mushroom Pizza',
            'slug' => 'mushroompizza',
            'sku' => '0001',
            'price' => '10.20',
            'discount_price' => '2.20',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'image' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
