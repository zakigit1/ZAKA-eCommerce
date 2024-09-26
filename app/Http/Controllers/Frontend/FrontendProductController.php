<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontendProductController extends Controller
{

    public function showProduct(string $slug){

        

        $data['product'] = Product::with([
            'gallery',
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
            }]
            )
        ->where('slug', $slug)->first();



        if (!$data['product']) {
            abort(404);
        }
        return view('frontend.store.product.product-details',$data);
    }



    public function productsIndex(Request $request){


        if($request->has('category')){

            $categoryId = Category::where('slug',$request->category)->firstOrFail()->id;
            $products = Product::where(['category_id' => $categoryId , 'is_approved' => 1])->active()->paginate(1);

        }elseif($request->has('sub_category')){
            
            $sub_categoryId = Subcategory::where('slug',$request->sub_category)->firstOrFail()->id;
            $products = Product::where(['sub_category_id' => $sub_categoryId , 'is_approved' => 1])->active()->paginate(2);

        }elseif($request->has('child_category')){

            $child_categoryId = Childcategory::where('slug',$request->child_category)->firstOrFail()->id;
            $products = Product::where(['child_category_id' => $child_categoryId , 'is_approved' => 1])->active()->paginate(2);

        }

        $categories = Category::active()->get(['id','name','slug']);

        return  view('Frontend.store.product.index' ,compact('products','categories'));
    }



    public function changeViewList(Request $request){

        Session::put('product_list_view_style',$request->style);

    }



}
