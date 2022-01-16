<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            ProfileSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            UnitSeeder::class,
            SupplierSeeder::class,
            ItemSeeder::class,
            InvoiceSeeder::class,
            CustomerSeeder::class,
            CouponSeeder::class,
            ConfigSeeder::class,
        ]);
    }
}
