<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
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

        $data['typeBaseProducts'] = $this->getTypeProducts();

        $data['productSliderSectionOne'] = HomePageSetting::where('key','product_slider_section_one')->first();
        $data['productSliderSectionOne'] = json_decode($data['productSliderSectionOne']->value,true);

        $data['productSliderSectionTwo'] = HomePageSetting::where('key','product_slider_section_two')->first();
        $data['productSliderSectionTwo'] = json_decode($data['productSliderSectionTwo']->value,true);
       
        $data['weeklyBestProducts'] = HomePageSetting::where('key','weekly_best_products')->first();
        $data['weeklyBestProducts'] = json_decode(@$data['weeklyBestProducts']->value,true);


        //banners sections 

        /** Top Category Product Banners */
        $data['homepageBannerSectionOne'] = Advertisement::where('key','homepage_banner_section_one')->first();
        $data['homepageBannerSectionOne'] = json_decode($data['homepageBannerSectionOne']?->value);
        
        /** Single Banner */
        $data['homepageBannerSectionTwo'] = Advertisement::where('key','homepage_banner_section_two')->first();
        $data['homepageBannerSectionTwo'] = json_decode($data['homepageBannerSectionTwo']?->value);
        
        /** Hot Deal Banner */
        $data['homepageBannerSectionThree'] = Advertisement::where('key','homepage_banner_section_three')->first();
        $data['homepageBannerSectionThree'] = json_decode($data['homepageBannerSectionThree']?->value);
        
        /** Large Banner */
        $data['homepageBannerSectionFour'] = Advertisement::where('key','homepage_banner_section_four')->first();
        $data['homepageBannerSectionFour'] = json_decode($data['homepageBannerSectionFour']?->value);



        // dd( $data['typeBaseProducts']);
        return view('frontend.store.home.home',$data);
    }






    /** Get the products depending on the type : */
    public function getTypeProducts(){
        $typeBaseProduct = [];

        $typeBaseProduct['new_arrival'] = Product::where(['product_type' => 'new_arrival' , 'is_approved' => 1 , 'status' => 1])->orderBy('id','DESC')->take(8)->get();
        $typeBaseProduct['featured_product'] = Product::where(['product_type' => 'featured_product' , 'is_approved' => 1 , 'status' => 1])->orderBy('id','DESC')->take(8)->get();
        $typeBaseProduct['top_product'] = Product::where(['product_type' => 'top_product' , 'is_approved' => 1 , 'status' => 1])->orderBy('id','DESC')->take(8)->get();
        $typeBaseProduct['best_product'] = Product::where(['product_type' => 'best_product' , 'is_approved' => 1 , 'status' => 1])->orderBy('id','DESC')->take(8)->get();

        return $typeBaseProduct ;
    }







}


