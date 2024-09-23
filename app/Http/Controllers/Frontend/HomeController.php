<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){


        // $sliders = Slider::where('status',1)->orderBy('serial','asc')->get();
        
        
        // $data['flashSaleItem'] = FlashSaleItem::with(['product'=>function($query){
        //     return $query->select('id','name')->get();
        // }])->where('show_at_home',1)->active()->get();
        
        //we need to modify get with pagination
        $data['sliders'] = Slider::orderBy('serial','asc')->active()->get();

        $data['flashSale'] = FlashSale::first();

        $data['flashSaleItem'] = FlashSaleItem::where('show_at_home',1)->active()->get();

        $data['popularCategories'] = HomePageSetting::where('key','popular_category_section')->first();
        $data['popularCategories'] = json_decode($data['popularCategories']->value,true);//true mean the data inside the array will be in array form not a object like when we use it first one in admin dashboard 

        // $data['brands'] = Brand::where('is_featured',1)->active()->get();
        $data['brands'] = Brand::active()->isFeatured()->get();

        // dd( $data['brands']);

        return view('frontend.store.home.home',$data);
    }
}
