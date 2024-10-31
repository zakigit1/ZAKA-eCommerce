<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    

    public function index(){

        $flashSale = FlashSale::first();

        // $flashSaleItem = FlashSaleItem::active()->orderBy('id','asc')->paginate(20);// this is the previous method

        //? this is the optimize method
        $flashSaleItemProductId = FlashSaleItem::active()->orderBy('id','asc')->pluck('product_id')->toArray();
       
        return view('Frontend.store.pages.flash-sale-see-more',compact('flashSale','flashSaleItemProductId'));
    }
}
