<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackOrderController extends Controller
{
    public function index(Request $request){
        // dd($request->all());
        if($request->has('order_id')){

            // This if the user enter order id with '#' character we filter it 

            $order_id = $request->order_id;
            $char = '#';

            if (strpos($order_id, $char) !== false) {
                $order_id = str_replace($char, '', $order_id);
            }

            // dd($order_id);

            $order = Order::where(['invoice_id' => $order_id , 'user_id' => Auth::user()->id])->first();
            

            return view('Frontend.store.pages.track-order',compact('order'));
        }


        // dd('yes');
        return view('Frontend.store.pages.track-order');

    }
}
