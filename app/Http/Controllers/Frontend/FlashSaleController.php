<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    

    public function index(){

        $data['flashSale'] = FlashSale::first();
        // $data['flashSaleItem'] = FlashSaleItem::active()->orderBy('id','asc')->paginate(1);
        $data['flashSaleItem'] = FlashSaleItem::with(['product'=>function($q){
            return $q->with([
                
                        'gallery',
                        'variants'=>function($query){
                            return $query->with(['items'=>function($q){//items = variant items
                                // get just variant items active 
                                return $q->where('status',1);
                            }])
                            // get just variant active 
                            ->where('status',1);
                        },
                        'vendor'=>function($query){
                            return $query->with('user');
                        },
                        'brand'=>function($query){
                            // get just brand active 
                            return $query->where('status',1);
                        }])

                    ->where('status',1);
        }])->active()->orderBy('id','asc')->paginate(20);

        return view('Frontend.store.pages.flash-sale-see-more',$data);
    }
}
