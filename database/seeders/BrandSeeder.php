<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        DB::table('brands')->insert([
            'name' => 'FFC',
            'slug' => 'ffc',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'PizzaHut',
            'slug' => 'pizzahut',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'PizzaInn',
            'slug' => 'pizzainn',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'HungryDuck',
            'slug' => 'hungryduck',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'CP',
            'slug' => 'cp',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'Khazana',
            'slug' => 'khazana',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'Radhuni',
            'slug' => 'radhuni',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'Ekushe',
            'slug' => 'ekushe',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
