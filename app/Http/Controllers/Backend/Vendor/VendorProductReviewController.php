<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\VendorProductReviewDataTable;
use App\Http\Controllers\Controller;

class VendorProductReviewController extends Controller
{
    public function index(VendorProductReviewDataTable  $dataTable){
        return $dataTable->render('vendor.review.index');    
    }
}
