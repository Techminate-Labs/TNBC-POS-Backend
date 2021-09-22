<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'admin',
            'permissions'=> '[{"Users":{"create":false,"view":false,"edit":false,"delete":false,"list":false}},{"Roles":{"create":true,"view":false,"edit":true,"delete":true,"list":false}}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        
        DB::table('roles')->insert([
            'name'=>'cashier',
            'permissions'=> '[{"Users":{"create":false,"view":false,"edit":false,"delete":false,"list":false}},{"Roles":{"create":true,"view":false,"edit":true,"delete":true,"list":false}}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Sazid',
            'email' => 'sazidahmed.official@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('profiles')->insert([
            'user_id' => '1',
            'first_name' => 'Sazid',
            'last_name' => 'Ahmed',
            'mobile' => '01680800810',
            'present_address' => 'Uttara, dhaka, Bangladesh, 1230',
            'permanent_address' => 'Uttara, dhaka, Bangladesh, 1230',
            'identity_number' => '991551221',
            'zip' => '1230',
            'city' => 'Dhaka',
            'image' => 'http://127.0.0.1:8000/images/profile/default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('profiles')->insert([
            'user_id' => '2',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'mobile' => '01911908431',
            'present_address' => 'Uttara, dhaka, Bangladesh, 1230',
            'permanent_address' => 'Uttara, dhaka, Bangladesh, 1230',
            'identity_number' => '981661333',
            'zip' => '1230',
            'city' => 'Dhaka',
            'image' => 'http://127.0.0.1:8000/images/profile/default.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
