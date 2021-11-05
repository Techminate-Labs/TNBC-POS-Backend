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
            'name' => 'Cheese Pizza',
            'slug' => 'cheesepizza',
            'sku' => '1100',
            'price' => '100',
            'discount' => '5',
            'inventory' => '5',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/cheesepizza.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '1',
            'brand_id' => '2',
            'unit_id' => '2',
            'supplier_id' => '1',
            'name' => 'Pen Pizza',
            'slug' => 'penpizza',
            'sku' => '1200',
            'price' => '150',
            'discount' => '5',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/penpizza.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '1',
            'brand_id' => '1',
            'unit_id' => '3',
            'supplier_id' => '1',
            'name' => 'Special Pizza',
            'slug' => 'specialpizza',
            'sku' => '1200',
            'price' => '150',
            'discount' => '5',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/specialpizza.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '2',
            'brand_id' => '3',
            'unit_id' => '2',
            'supplier_id' => '1',
            'name' => 'Beef Burger',
            'slug' => 'beefburger',
            'sku' => '1300',
            'price' => '60',
            'discount' => '5',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/burger.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '6',
            'brand_id' => '6',
            'unit_id' => '4',
            'supplier_id' => '1',
            'name' => 'Coffee',
            'slug' => 'coffee',
            'sku' => '1400',
            'price' => '50',
            'discount' => '5',
            'inventory' => '10',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/coffee.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '4',
            'brand_id' => '4',
            'unit_id' => '5',
            'supplier_id' => '4',
            'name' => 'Fried Chicken',
            'slug' => 'friedchicken',
            'sku' => '1500',
            'price' => '85',
            'discount' => '10',
            'inventory' => '7',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/friedchicken.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '7',
            'brand_id' => '8',
            'unit_id' => '7',
            'supplier_id' => '4',
            'name' => 'Noodles',
            'slug' => 'noodles',
            'sku' => '1600',
            'price' => '100',
            'discount' => '5',
            'inventory' => '3',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/noodles.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '8',
            'brand_id' => '8',
            'unit_id' => '7',
            'supplier_id' => '4',
            'name' => 'Pasta',
            'slug' => 'pasta',
            'sku' => '1700',
            'price' => '120',
            'discount' => '5',
            'inventory' => '3',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/pasta.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '5',
            'brand_id' => '9',
            'unit_id' => '7',
            'supplier_id' => '4',
            'name' => 'Fried Rice',
            'slug' => 'friedrice',
            'sku' => '1800',
            'price' => '100',
            'discount' => '5',
            'inventory' => '3',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/rice.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '5',
            'brand_id' => '4',
            'unit_id' => '7',
            'supplier_id' => '10',
            'name' => 'Shrimp Rice',
            'slug' => 'shrimprice',
            'sku' => '1800',
            'price' => '150',
            'discount' => '5',
            'inventory' => '3',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/shrimprice.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '3',
            'brand_id' => '8',
            'unit_id' => '7',
            'supplier_id' => '4',
            'name' => 'Corn Soup',
            'slug' => 'cornsoup',
            'sku' => '1900',
            'price' => '100',
            'discount' => '5',
            'inventory' => '3',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/soup.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('items')->insert([
            'category_id' => '3',
            'brand_id' => '8',
            'unit_id' => '7',
            'supplier_id' => '4',
            'name' => 'Thai Soup',
            'slug' => 'thaisoup',
            'sku' => '1900',
            'price' => '100',
            'discount' => '5',
            'inventory' => '3',
            'expire_date' => '2021-09-22 15:06:48',
            'available' => '1',
            'image' => 'http://127.0.0.1:8000/images/item/thaisoup.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
