<?php

namespace App\Http\Controllers\Backend\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use App\Models\RazorpaySetting;
use App\Models\StripeSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index(){

        $data['paypalSetting'] = PaypalSetting::first();
        $data['stripeSetting'] = StripeSetting::first();
        $data['razorpaySetting'] = RazorpaySetting::first();
        return view('admin.payment-setting.index',$data);
    }
}
