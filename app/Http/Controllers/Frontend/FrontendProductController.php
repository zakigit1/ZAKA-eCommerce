<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Subcategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class FrontendProductController extends Controller
{
    //Product Details
    public function showProduct(string $slug){

        try{

            $data['product'] = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([
                    'gallery',
                    'reviews'=>function($query){
                        // get just brand active 
                        $query->where('status',1);
                    },
                    'variants'=>function($query){
                        return $query->with(['items'=>function($q){//items = variant items
                            // get just variant items active 
                            return $q->where('status',1);
                        }])
                        // get just variant active 
                        ->where('status',1);
                    },
                    'vendor'=>function($query){
                        return $query->with('user');
                    },
                    'brand'=>function($query){
                        // get just brand active 
                        $query->where('status',1);
                    }])
                ->where('slug', $slug)
                ->first();
    
            $data['reviews'] = ProductReview::with(['user','productReviewGalleries'])
                ->where(['product_id' => $data['product']->id , 'status' => 1])
                ->paginate(5);
    
            if (!$data['product']) {
                abort(404);
            }

            // dd($data['reviews']);
            
            return view('frontend.store.product.product-details',$data);
        }catch(\Exception $e){
            toastr($e->getMessage(),'error','Error');
            return redirect()->back();
        }
    }



    public function productsIndex(Request $request){

        // dd($request->query());// this is like dd($request->all())
        
        if($request->has('category')){

            $categoryId = Category::where('slug',$request->category)->firstOrFail()->id;
            $products = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([                            
                    'gallery',
                    'category', 
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
                }])
                ->where(['category_id' => $categoryId , 'is_approved' => 1])
                ->active()
                ->when($request->has('price_range') && $request->price_range != null ,function($query) use($request) {
                    $price = explode(';',$request->price_range);
                    $from = $price [0];
                    $to = $price [1];

                    return $query->where('price','>=',$from)->where('price','<=',$to);
                })
                ->paginate(12);

        }elseif($request->has('sub_category')){
            
            $sub_categoryId = Subcategory::where('slug',$request->sub_category)->firstOrFail()->id;
            $products = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([                            
                    'gallery',
                    'category', 
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
                }])
                ->where(['sub_category_id' => $sub_categoryId , 'is_approved' => 1])
                ->when($request->has('price_range') && $request->price_range != null ,function($query) use($request) {
                    $price = explode(';',$request->price_range);
                    $from = $price [0];
                    $to = $price [1];

                    return $query->where('price','>=',$from)->where('price','<=',$to);
                })
                ->active()
                ->paginate(12);

        }elseif($request->has('child_category')){

            $child_categoryId = Childcategory::where('slug',$request->child_category)->firstOrFail()->id;
            $products = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([                            
                    'gallery',
                    'category', 
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
                }])
                ->where(['child_category_id' => $child_categoryId , 'is_approved' => 1])
                ->when($request->has('price_range') && $request->price_range != null ,function($query) use($request) {
                    $price = explode(';',$request->price_range);
                    $from = $price [0];
                    $to = $price [1];

                    return $query->where('price','>=',$from)->where('price','<=',$to);
                })
                ->active()
                ->paginate(12);
            
        }elseif($request->has('brand')){
            $brandId = Brand::where('slug',$request->brand)->firstOrFail()->id;
            $products = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([                            
                    'gallery',
                    'category', 
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
                }])
                ->where(['brand_id' => $brandId , 'is_approved' => 1])
                ->when($request->has('price_range') && $request->price_range != null ,function($query) use($request) {
                    $price = explode(';',$request->price_range);
                    $from = $price [0];
                    $to = $price [1];

                    return $query->where('price','>=',$from)->where('price','<=',$to);
                })
                ->active()
                ->paginate(12);

        }elseif($request->has('search')){
            $products = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([                            
                    'gallery',
                    'category', 
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
                }])
                ->where('is_approved' , 1)
                ->active()
                ->where(function($query) use ($request){
                    $query->where('name','like' ,'%' .$request->search .'%')

                    ->orWhere('long_description','like' ,'%' .$request->search .'%')

                    ->orWhereHas('category',function($query) use ($request){
                        $query->where('name','like' ,'%' .$request->search .'%');
                    })
                    ->orWhereHas('subcategory',function($query) use ($request){
                        $query->where('name','like' ,'%' .$request->search .'%');
                    })
                    ->orWhereHas('childcategory',function($query) use ($request){
                        $query->where('name','like' ,'%' .$request->search .'%');
                    })
                    ->orWhereHas('brand',function($query) use ($request){
                        $query->where('name','like' ,'%' .$request->search .'%');
                    });
            })
            ->when($request->has('price_range') && $request->price_range != null ,function($query) use($request) {
                $price = explode(';',$request->price_range);
                $from = $price [0];
                $to = $price [1];

                return $query->where('price','>=',$from)->where('price','<=',$to);
            })
            ->paginate(12);

        }else{
            $products = Product::withAvg('reviews','rating')
                ->withCount('reviews')
                ->with([                            
                    'gallery',
                    'category', 
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
                }])
                ->where('is_approved' , 1)
                ->active()
                ->when($request->has('price_range') && $request->price_range != null ,function($query) use($request) {
                    $price = explode(';',$request->price_range);
                    $from = $price [0];
                    $to = $price [1];

                    return $query->where('price','>=',$from)->where('price','<=',$to);
                })
                ->orderBy('id','DESC')
                ->paginate(12);
        }

        $categories = Category::active()->get(['id','name','slug']);
        $brands = Brand::active()->get(['id','name','slug']);

        $productpageBanner = Advertisement::where('key','productpage_banner')->first();
        $productpageBanner = json_decode($productpageBanner?->value);

        return  view('Frontend.store.product.index' ,compact('products','categories','brands','productpageBanner'));
    }


    public function changeViewList(Request $request){
        Session::put('product_list_view_style',$request->style);
    }



}
