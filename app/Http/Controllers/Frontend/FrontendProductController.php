<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;


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
}
