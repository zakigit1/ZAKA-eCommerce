<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Schema::hasTable('users')){
            if (DB::table('users')->count() === 0) {
                DB::table('users')->insert($this->users());
            }
        }
    }


    public function users(){

       return [
            [
                'name'=>'admin',
                'username'=>'adminuser',
                'email'=>'admin@gmail.com',
                'role'=>'admin',
                'password'=>bcrypt('password'),
                // 'status' => 'active',// it have default value 'active'
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name'=>'vendor',
                'username'=>'vendoruser',
                'email'=>'vendor@gmail.com',
                'role'=>'vendor',
                'password'=>bcrypt('password'),
                // 'status' => 'active',// it have default value 'active'
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'name'=>'user',
                'username'=>'user',
                'email'=>'user@gmail.com',
                'role'=>'user',
                'password'=>bcrypt('password'),
                // 'status' => 'active',// it have default value 'active'
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        ];
    }
}
