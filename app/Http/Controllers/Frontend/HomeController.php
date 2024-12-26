<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    public function index():View
    {


        // $sliders = Slider::where('status',1)->orderBy('serial','asc')->get();
    
        // $data['flashSaleItem'] = FlashSaleItem::with(['product'=>function($query){
        //     return $query->select('id','name')->get();
        // }])->where('show_at_home',1)->active()->get();

        
        
        // $data['sliders'] = Slider::orderBy('serial','asc')->active()->take(3)->get();
        /** we cache the sliders in caching */
    
        $data['sliders'] = Cache::rememberForever('sliders',function(){
            return Slider::orderBy('serial','asc')->active()->take(3)->get();
        });
        



        // $data['flashSaleItem'] = FlashSaleItem::where('show_at_home',1)->active()->take(12)->get();
        /** the new update of optimization 521 */
        $data['flashSaleItemProductId'] = FlashSaleItem::where('show_at_home',1)->active()->pluck('product_id')->toArray();

        
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

        /** Flash Sale End Date Banner */
        $data['homepageBannerFlashSaleEndDate'] = Advertisement::where('key','homepage_banner_flash_sale_end_date')->first();
        $data['homepageBannerFlashSaleEndDate'] = json_decode($data['homepageBannerFlashSaleEndDate']?->value);


        

        /** Blogs */
        $data['blogs'] = Blog::with('blogcategory')->where('status',1)->orderBy('id','DESC')->take(8)->get();
        



        
        // dd( $data['blogs']);
        return view('frontend.store.home.home',$data);
    }

    /** Get the products depending on the type : */
    public function getTypeProducts(): array
    {
        $typeBaseProduct = [];

        $typeBaseProduct['new_arrival'] = $this->getproductsByType('new_arrival');
        $typeBaseProduct['featured_product'] = $this->getproductsByType('featured_product');
        $typeBaseProduct['top_product'] = $this->getproductsByType('top_product');
        $typeBaseProduct['best_product'] = $this->getproductsByType('best_product');



        // $typeBaseProduct['new_arrival'] = Product::
        //     with([
        //         'gallery',
        //         'category',
        //         'reviews'=>function($query){
        //             $query->where('status',1);
        //         },
        //         'variants'=>function($query){
        //             $query->with(['items' => function ($q) {
        //                         $q->where('status', 1);
        //                         },
        //                 ])->where('status',1);
        //         },
        //         'brand'=>function($query){
        //             $query->where('status',1);
        //         }])
        //     ->where(['product_type' => 'new_arrival' , 'is_approved' => 1 , 'status' => 1])
        //     ->orderBy('id','DESC')
        //     ->take(8)
        //     ->get();
        
        
        // $typeBaseProduct['featured_product'] = Product::
        //     with([
        //         'gallery',
        //         'category',
        //         'reviews'=>function($query){
        //             $query->where('status',1);
        //         },
        //         'variants'=>function($query){
        //             $query->with(['items' => function ($q) {
        //                         $q->where('status', 1);
        //                         },
        //                 ])->where('status',1);
        //         },
        //         'brand'=>function($query){
        //             $query->where('status',1);
        //         }])
        //     ->where(['product_type' => 'featured_product' , 'is_approved' => 1 , 'status' => 1])
        //     ->orderBy('id','DESC')
        //     ->take(8)
        //     ->get();
        
        
        // $typeBaseProduct['top_product'] = Product::
        //     with([
        //         'gallery',
        //         'category',
        //         'reviews'=>function($query){
        //             $query->where('status',1);
        //         },
        //         'variants'=>function($query){
        //             $query->with(['items' => function ($q) {
        //                         $q->where('status', 1);
        //                         },
        //                 ])->where('status',1);
        //         },
        //         'brand'=>function($query){
        //             $query->where('status',1);
        //         }])
        //     ->where(['product_type' => 'top_product' , 'is_approved' => 1 , 'status' => 1])
        //     ->orderBy('id','DESC')
        //     ->take(8)
        //     ->get();
        
        
        // $typeBaseProduct['best_product'] = Product::
        //     with([
        //         'gallery',
        //         'category',
        //         'reviews'=>function($query){
        //             $query->where('status',1);
        //         },
        //         'variants'=>function($query){
        //             $query->with(['items' => function ($q) {
        //                         $q->where('status', 1);
        //                         },
        //                 ])->where('status',1);
        //         },
        //         'brand'=>function($query){
        //             $query->where('status',1);
        //         }])
        //     ->where(['product_type' => 'best_product' , 'is_approved' => 1 , 'status' => 1])
        //     ->orderBy('id','DESC')
        //     ->take(8)
        //     ->get();

        return $typeBaseProduct ;
    }

    private function getproductsByType($type)
    {

        $products = Product::withAvg('reviews','rating')
            ->withCount('reviews')
            ->with([
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
            ->where(['product_type' => "$type" , 'is_approved' => 1 , 'status' => 1])
            ->orderBy('id','DESC')
            ->take(8)
            ->get();

        return $products;
    }



    public function vednorIndex():View
    {

        $vendors = Vendor::with(['products'=>function($query){
            $query->with([
                'reviews'=>function($query){
                    $query->where('status' , 1);
                }]);
        }])->where('status' , 1)->paginate(20);

        return view('Frontend.store.pages.vendor.index',compact('vendors'));
    }
   
    public function vendorProducts(String $id):View
    {

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
            ])
            ->where(['status' => 1 ,'is_approved' => 1,'vendor_id' => $id])
            ->orderBy('id','DESC')
            ->paginate(12);
        
        $vendor = Vendor::with('products')->find($id);

        if(!$vendor){
            return abort(404);
        }

        return view('Frontend.store.pages.vendor.vendor-products',compact('products','vendor'));
    }

    public function showProductModel(string $id)   
    {
       try{

           $product = Product::withAvg('reviews','rating')
               ->withCount('reviews')
               ->with([
                   'variants' => function ($query) {
                       $query->with([
                               'items' => function ($q) {
                                   $q->where('status', 1);
                               },
                           ])
                           ->where('status', 1);
                   },
                   'reviews' => function ($query) {
                       // get just reviews active
                       $query->where('status', 1);
                   },
                   'brand'])
           ->find($id);
   
            
           // $product = Product::find($id);
   
           if(!$product){
               return response(['status'=>'error','message'=>'product not found !']);
           }
   
           // radi n3rdo product model file with ajax
           $content = view('Frontend.store.layouts.includes.model',compact('product'))->render();
   
           return Response::make($content, 200,['Content-Type' => 'text/html']);

       }catch(\Exception $ex){
        return response(['status'=>'error','message'=>$ex->getMessage()]);
       }

    }


    /** View List Dynamique Of Mobile Menu (categories , main menu) */
    public function changeViewList(Request $request):void
    {
        Session::put('mobile_menu_view_list',$request->style);
    }

}


