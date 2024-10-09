<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AdminVendorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
               
        DB::table('vendors')->insert($this->admin_vendor_profile());

    }


    public function admin_vendor_profile(){

        // $user_id = User::where('email','admin@gmail.com')->first(['id']);
        
        $user=User:: where('email','admin@gmail.com')->first();
       return [
            [
                'banner'=>'adminVendorProfile_default.jpg',
                'shop_name'=>'Admin Shop',
                'phone'=>'0000000000',
                'email'=>'admin@gmail.com',
                'address'=>'Algeria-oran',
                'description'=>'bio bio bio bio biob iobo',
                'user_id'=>$user->id,
                'status'=>1,
            ],
        ];
    }

}
