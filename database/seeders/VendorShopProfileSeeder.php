<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                  
        DB::table('vendors')->insert($this->vendor_profile());
    
    }
    
    
        public function vendor_profile(){
    
            $user=User::where('email','vendor@gmail.com')->first();

           return [
                [
                    'banner'=>'VendorProfile_default.jpg',
                    'shop_name'=>'Vendor Shop',
                    'phone'=>'111111111',
                    'email'=>'vendor@gmail.com',
                    'address'=>'Algeria-Oran',
                    'description'=>'bio bio bio bio biob iobo',
                    'user_id'=>$user->id,
                    'status' => 1,
                ],
            ];
        }
    
}
