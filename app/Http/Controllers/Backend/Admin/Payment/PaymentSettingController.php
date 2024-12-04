<?php

namespace App\Http\Controllers\Backend\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Models\CODSetting;
use App\Models\PaypalSetting;
use App\Models\RazorpaySetting;
use App\Models\StripeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PaymentSettingController extends Controller
{
    public function index(): View     
    {
        $data['paypalSetting'] = PaypalSetting::first();
        $data['stripeSetting'] = StripeSetting::first();
        $data['razorpaySetting'] = RazorpaySetting::first();
        $data['codSetting'] = CODSetting::first();

        return view('admin.payment-setting.index',$data);
    }



    /** View List Dynamique */
    public function changeViewList(Request $request): void    
    {
        Session::put('payment_settings_view_list',$request->style);
    }
}
