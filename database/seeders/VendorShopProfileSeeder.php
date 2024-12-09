<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        if(Schema::hasTable('vendors')){
            if (DB::table('vendors')->count() === 0) {
                DB::table('vendors')->insert($this->vendor_profile());
            }
        }
    }
    
    
        public function vendor_profile(){
    
            $user = User::where('email','vendor@gmail.com')->first();

           return [
                [
                    'banner' => 'VendorProfile_default.jpg',
                    'shop_name' => 'Vendor Shop',
                    'phone' => '+213 0564096090',
                    'email' => 'vendor@gmail.com',
                    'address' => 'Algeria-Oran',
                    'description' => 'bio bio bio bio bio bio',
                    'user_id' => $user->id,
                    'status' =>  1,
                ],
            ];
        }
    
}
