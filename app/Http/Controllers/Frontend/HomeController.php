<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){


        // $sliders = Slider::where('status',1)->orderBy('serial','asc')->get();
        
        
        //we need to modify get with pagination
        $sliders = Slider::orderBy('serial','asc')->active()->get();

        return view('frontend.store.home.home',compact('sliders'));
    }
}
