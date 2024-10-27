<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    public function index(){


        // $sliders = Slider::where('status',1)->orderBy('serial','asc')->get();
    
        // $data['flashSaleItem'] = FlashSaleItem::with(['product'=>function($query){
        //     return $query->select('id','name')->get();
        // }])->where('show_at_home',1)->active()->get();

        
        //we need to modify get with pagination
        $data['sliders'] = Slider::orderBy('serial','asc')->active()->take(3)->get();

        $data['flashSaleItem'] = FlashSaleItem::where('show_at_home',1)->active()->take(12)->get();
        // $data['flashSaleItem'] = FlashSaleItem::where('show_at_home',1)->active()->pluck('product_id');

        
        $data['flashSale'] = FlashSale::first();


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

        /** Blogs */
        $data['blogs'] = Blog::with('blogcategory')->where('status',1)->orderBy('id','DESC')->take(8)->get();
        



        
        // dd( $data['blogs']);
        return view('frontend.store.home.home',$data);
    }

    /** Get the products depending on the type : */
    public function getTypeProducts(){
        $typeBaseProduct = [];

        $typeBaseProduct['new_arrival'] = Product::
            with([
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                },
                'brand'=>function($query){
                    $query->where('status',1);
                }])
            ->where(['product_type' => 'new_arrival' , 'is_approved' => 1 , 'status' => 1])
            ->orderBy('id','DESC')
            ->take(8)
            ->get();
        
        
        $typeBaseProduct['featured_product'] = Product::
            with([
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                },
                'brand'=>function($query){
                    $query->where('status',1);
                }])
            ->where(['product_type' => 'featured_product' , 'is_approved' => 1 , 'status' => 1])
            ->orderBy('id','DESC')
            ->take(8)
            ->get();
        
        
        $typeBaseProduct['top_product'] = Product::
            with([
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                },
                'brand'=>function($query){
                    $query->where('status',1);
                }])
            ->where(['product_type' => 'top_product' , 'is_approved' => 1 , 'status' => 1])
            ->orderBy('id','DESC')
            ->take(8)
            ->get();
        
        
        $typeBaseProduct['best_product'] = Product::
            with([
                'gallery',
                'category',
                'reviews'=>function($query){
                    $query->where('status',1);
                },
                'variants'=>function($query){
                    $query->with(['items' => function ($q) {
                                $q->where('status', 1);
                                },
                        ])->where('status',1);
                },
                'brand'=>function($query){
                    $query->where('status',1);
                }])
            ->where(['product_type' => 'best_product' , 'is_approved' => 1 , 'status' => 1])
            ->orderBy('id','DESC')
            ->take(8)
            ->get();

        return $typeBaseProduct ;
    }

    public function vednorIndex(){

        $vendors = Vendor::with(['products'=>function($query){
            $query->with([
                'reviews'=>function($query){
                    $query->where('status' , 1);
                }]);
        }])->where('status' , 1)->paginate(20);

        return view('Frontend.store.pages.vendor.index',compact('vendors'));
    }
   
    public function vendorProducts(String $id){

        $products = Product::with([
            'gallery',
            'category',
            'reviews'=>function($query){
                $query->where('status',1);
            },
            'variants' => function ($query) {
                $query->with([
                        'items' => function ($q) {
                            $q->where('status', 1);
                        },
                    ])
                    ->where('status', 1);
            },
            'brand'
            ])->where(['status' => 1 ,'is_approved' => 1,'vendor_id' => $id])->orderBy('id','DESC')->paginate(12);
        
        $vendor = Vendor::with('products')->find($id);

        if(!$vendor){
            return abort(404);
        }




        return view('Frontend.store.pages.vendor.vendor-products',compact('products','vendor'));
    }

    public function showProductModel(string $id){
       
        // $product = Product::withAvg('reviews','rating')
        //     ->withCount('reviews')
        //     ->with([
        //         'variants' => function ($query) {
        //             $query->with([
        //                     'items' => function ($q) {
        //                         $q->where('status', 1);
        //                     },
        //                 ])
        //                 ->where('status', 1);
        //         },
        //         'reviews' => function ($query) {
        //             // get just reviews active
        //             $query->where('status', 1);
        //         },
        //         'brand'])
        // ->find($id);


        $product = Product::find($id);
        if(!$product){
            return response(['status'=>'error','message'=>'product not found !']);
        }

        // radi n3rdo product model file with ajax
        $content = view('Frontend.store.layouts.includes.model',compact('product'))->render();

        return Response::make($content, 200,['Content-Type' => 'text/html']);

    }



}


