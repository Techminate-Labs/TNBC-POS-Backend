<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'app_name' => 'TNB POS',
            'store_name' => 'Techminate',
            'currency' => 'USD',
            'currency_symble' => '$',
            'tnbc_pk' => 'a5dbcded3501291743e0cb4c6a186afa2c87a54f4a876c620dbd68385cba80d0',
            'tnbc_rate' => '0.02',
            'usd_rate' => '1',
            'tax_rate' => '10.00',
            'time_zone' => 'GMT+6',
            'app_logo' => 'http://127.0.0.1:8000/images/logo/default.png',
            'store_logo' => 'http://127.0.0.1:8000/images/logo/default.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
