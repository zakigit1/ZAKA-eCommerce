<?php

namespace Database\Seeders;

use App\Models\User;
use illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminVendorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        if(Schema::hasTable('vendors')){
            if (DB::table('vendors')->count() === 0) {
                DB::table('vendors')->insert($this->admin_vendor_profile());
            }
        }
    }


    public function admin_vendor_profile(){

        // $user_id = User::where('email','admin@gmail.com')->first(['id']);
        
        $user = User:: where('email','admin@gmail.com')->first();
        return [
                [
                    'banner' => 'adminVendorProfile_default.jpg',
                    'shop_name' => 'Admin Shop',
                    'phone' => '+213 0782630320',
                    'email' => 'admin@gmail.com',
                    'address' => 'Algeria-oran',
                    'description' => 'description description description description description',
                    'user_id' => $user->id,
                    'status' => 1,
                ],
        ];
    }

}
