<?php

namespace App\Http\Controllers\Backend\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index(){

        $paypalSetting = PaypalSetting::first();
        return view('admin.payment-setting.index',compact('paypalSetting'));
    }
}
