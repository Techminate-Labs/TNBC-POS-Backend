<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'name' => 'Jhon Doe',
            'email' => 'jhone@gmail.com',
            'phone' => '01680800800',
            'address' => 'dhaka',
            'point' => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customers')->insert([
            'name' => 'Jenny Doe',
            'email' => 'jenny@gmail.com',
            'phone' => '01680800800',
            'address' => 'dhaka',
            'point' => '5',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customers')->insert([
            'name' => 'Jho Doe',
            'email' => 'jho@gmail.com',
            'phone' => '01680800800',
            'address' => 'dhaka',
            'point' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customers')->insert([
            'name' => 'Jonny Doe',
            'email' => 'jonny@gmail.com',
            'phone' => '01680800800',
            'address' => 'dhaka',
            'point' => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customers')->insert([
            'name' => 'Doel',
            'email' => 'doel@gmail.com',
            'phone' => '01680800800',
            'address' => 'banga',
            'point' => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        
    }
}
