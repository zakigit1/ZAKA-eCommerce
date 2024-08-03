<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    

    public function index(){

        $data['flashSale'] = FlashSale::first();
        $data['flashSaleItem'] = FlashSaleItem::active()->paginate(1);

        return view('Frontend.store.pages.flash-sale',$data);
    }
}
