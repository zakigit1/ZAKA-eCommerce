<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorMessageController extends Controller
{
    public function index() :View
    {
        return view('vendor.messanger.index');
    }
}
