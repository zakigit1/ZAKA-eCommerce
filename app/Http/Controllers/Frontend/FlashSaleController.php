<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;

class FlashSaleController extends Controller
{
    

    public function index(){

        $flashSale = FlashSale::first();

        // $flashSaleItem = FlashSaleItem::active()->orderBy('id','asc')->paginate(20);// this is the previous method

        //? this is the optimize method

        $flashSaleItemProductId = FlashSaleItem::whereHas('flashSale', function($query) {
            $query->whereNotNull('end_date');
        })
        ->active()
        ->orderBy('id', 'asc')
        ->pluck('product_id')
        ->toArray();

        $flashsaleseemoreBanner = Advertisement::where('key','flash_sale_see_more_banner')->first();
        $flashsaleseemoreBanner = json_decode($flashsaleseemoreBanner?->value);
       
        return view('Frontend.store.pages.flash-sale-see-more',compact('flashSale','flashSaleItemProductId','flashsaleseemoreBanner'));
    }
}
