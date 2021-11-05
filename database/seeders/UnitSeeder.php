<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name' => 'Small',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => 'Medium',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => 'Large',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '1 pis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '2 pis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '4 pis',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('units')->insert([
            'name' => '1 bowl',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
