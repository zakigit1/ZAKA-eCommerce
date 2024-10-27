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

        $flashSaleItem = FlashSaleItem::active()->orderBy('id','asc')->paginate(20);

        return view('Frontend.store.pages.flash-sale-see-more',compact('flashSale','flashSaleItem'));
    }
}
