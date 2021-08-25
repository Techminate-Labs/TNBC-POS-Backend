<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'admin',
            'permissions'=> '{"dashboard":{"can-list":"1"},"product":{"can-add":"1","can-edit":"1","can-delete":"1","can-view":"1","can-list":"1"},"report":{"can-add":"1","can-edit":"1","can-delete":"1","can-view":"1","can-list":"1"},"user":{"can-add":"1","can-edit":"1","can-delete":"1","can-view":"1","can-list":"1"},"customer":{"can-add":"1","can-edit":"1","can-delete":"1","can-view":"1","can-list":"1"},"role":{"can-add":"1","can-edit":"1","can-delete":"1","can-view":"1","can-list":"1"}}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        
        DB::table('roles')->insert([
            'name'=>'cashier',
            'permissions'=> '{"product":{"can-add":"1","can-edit":"1","can-delete":"1","can-view":"1","can-list":"1"}}',
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
    }
}
