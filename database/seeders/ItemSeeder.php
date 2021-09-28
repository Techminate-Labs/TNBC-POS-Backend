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
            'discount' => '2.20',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '1',
            'brand_id' => '1',
            'unit_id' => '1',
            'supplier_id' => '1',
            'name' => 'Pen Pizza',
            'slug' => 'penpizza',
            'sku' => '0001',
            'price' => '20.20',
            'discount' => '2.20',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '1',
            'brand_id' => '1',
            'unit_id' => '1',
            'supplier_id' => '1',
            'name' => 'Naga Burger',
            'slug' => 'nagaburger',
            'sku' => '0001',
            'price' => '30.20',
            'discount' => '2.20',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
