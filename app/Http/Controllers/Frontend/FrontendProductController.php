<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendProductController extends Controller
{
    public function showProduct(string $slug){

        

        $data['product'] = Product::with([
            'gallery',
            'variants'=>function($query){
                return $query->with('items');
            },
            'vendor'=>function($query){
                return $query->with('user');
            },
            'brand'
            ])
        ->where('slug', $slug)->first();



        if (!$data['product']) {
            abort(404);
        }
        return view('frontend.store.product.product-details',$data);
    }
}
