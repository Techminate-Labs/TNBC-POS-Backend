<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->insert([
            'user_id' => '1',
            'customer_id' => '1',
            'invoice_number' => 'POS_0116_585277',
            'payment_method' => 'tnbc',
            'subTotal' => '5000',
            'discount' => '250',
            'tax' => '500',
            'total' => '5500',
            'date' => '2022-01-16 11:31:55',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('invoices')->insert([
            'user_id' => '1',
            'customer_id' => '1',
            'invoice_number' => 'POS_0116_585277',
            'payment_method' => 'tnbc',
            'subTotal' => '5000',
            'discount' => '250',
            'tax' => '500',
            'total' => '5500',
            'date' => '2022-01-16 11:31:55',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('invoices')->insert([
            'user_id' => '1',
            'customer_id' => '1',
            'invoice_number' => 'POS_0116_585277',
            'payment_method' => 'tnbc',
            'subTotal' => '5000',
            'discount' => '250',
            'tax' => '500',
            'total' => '5500',
            'date' => '2022-01-16 11:31:55',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
