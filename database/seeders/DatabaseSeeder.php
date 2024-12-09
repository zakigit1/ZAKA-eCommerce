<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        // User::factory(20)->create();

        if(Schema::hasTable('users')){
            if (DB::table('users')->count() === 0) {
                $this->call([
                    UserSeeder::class,
                ]);

                if(Schema::hasTable('vendors')){
                    if(DB::table('vendors')->count() === 0){
                        $this->call([
                            AdminVendorProfileSeeder::class,
                            VendorShopProfileSeeder::class,
                        ]);
                    }
                }
            }   
        }   
    }
}
