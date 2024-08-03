<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(20)->create();


        if (DB::table('users')->count() === 0) {
            $this->call([
                UserSeeder::class,
                AdminVendorProfileSeeder::class,
                VendorShopProfileSeeder::class,

            ]);
        }   
        $this->call([
        ]);
    }
}
