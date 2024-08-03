<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){


        // $sliders = Slider::where('status',1)->orderBy('serial','asc')->get();
        
        
        // $data['flashSaleItem'] = FlashSaleItem::with(['product'=>function($query){
        //     return $query->select('id','name')->get();
        // }])->where('show_at_home',1)->active()->get();
        
        //we need to modify get with pagination
        $data['sliders'] = Slider::orderBy('serial','asc')->active()->get();
        $data['flashSale'] = FlashSale::first();
        $data['flashSaleItem'] = FlashSaleItem::where('show_at_home',1)->active()->get();

        return view('frontend.store.home.home',$data);
    }
}
