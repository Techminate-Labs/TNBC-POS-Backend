<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupons')->insert([
            'code' => '585251',
            'discount' => '5',
            'start_date' => '2021-09-22 15:06:48',
            'end_date' => '2021-09-22 15:06:48',
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('coupons')->insert([
            'code' => '521365',
            'discount' => '5',
            'start_date' => '2021-09-22 15:06:48',
            'end_date' => '2021-09-22 15:06:48',
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('coupons')->insert([
            'code' => '951151',
            'discount' => '5',
            'start_date' => '2021-09-22 15:06:48',
            'end_date' => '2021-09-22 15:06:48',
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('coupons')->insert([
            'code' => '121251',
            'discount' => '5',
            'start_date' => '2021-09-22 15:06:48',
            'end_date' => '2021-09-22 15:06:48',
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('coupons')->insert([
            'code' => '546251',
            'discount' => '5',
            'start_date' => '2021-09-22 15:06:48',
            'end_date' => '2021-09-22 15:06:48',
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('coupons')->insert([
            'code' => '456251',
            'discount' => '5',
            'start_date' => '2021-09-22 15:06:48',
            'end_date' => '2021-09-22 15:06:48',
            'active' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
