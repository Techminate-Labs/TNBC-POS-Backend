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
        DB::table('categories')->insert([
            'name' => 'Pizza',
            'slug' => 'pizza',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'name' => 'Burger',
            'slug' => 'burger',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'KFC',
            'slug' => 'kfc',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'BFC',
            'slug' => 'bfc',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '4 pis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '8 pis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '12 pis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        
    }
}
