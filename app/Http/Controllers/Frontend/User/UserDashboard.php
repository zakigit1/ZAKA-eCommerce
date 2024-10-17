<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Controller
{
    public function index(){
        
        $data['totalOrders'] = Order::where('user_id',Auth::user()->id)->count();

        
        $data['pendingOrders'] = Order::where(['user_id' => Auth::user()->id ,'order_status' => 'pending'])->count();
        
        $data['completeOrders'] = Order::where(['user_id' => Auth::user()->id ,'order_status' => 'delivered'])->count();
        
        $data['reviews'] = ProductReview::where('user_id',Auth::user()->id)->count();
        
        $data['wishlists'] = Wishlist::where('user_id',Auth::user()->id)->count();
        

        return view('Frontend.user.Dashboard.dashboard',$data);
    }
}
