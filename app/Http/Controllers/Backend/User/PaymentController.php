<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function index(){

        if(!Session::has('shipping_address')){
            return redirect()->route('user.checkout');
        }

        return view('Frontend.store.pages.payment');
    }
}
