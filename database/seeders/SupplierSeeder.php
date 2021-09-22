<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->insert([
            'name' => 'Jhon Doe',
            'email' => 'jhone@gmail.com',
            'phone' => '01680800800',
            'company' => 'techminate',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('suppliers')->insert([
            'name' => 'Jenny Doe',
            'email' => 'jenny@gmail.com',
            'phone' => '01990800800',
            'company' => 'techminate',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('suppliers')->insert([
            'name' => 'Tommy Doe',
            'email' => 'tommy@gmail.com',
            'phone' => '01880800808',
            'company' => 'techminate',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('suppliers')->insert([
            'name' => 'Abby Doe',
            'email' => 'abby@gmail.com',
            'phone' => '01680800809',
            'company' => 'techminate',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('suppliers')->insert([
            'name' => 'Roy Doe',
            'email' => 'roy@gmail.com',
            'phone' => '01680800810',
            'company' => 'techminate',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
