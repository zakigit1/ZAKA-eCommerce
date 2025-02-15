<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\FlashSaleProductView;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable)
    {

        // $products = Product::where('is_approved',1)
        //                         ->active()
        //                         ->orderBy('id','desc')
        //                         ->get(['id','name']);


        $products = FlashSaleProductView::orderBy('product_id', 'desc')
            ->get(['product_id', 'product_name']);

        // $products = DB::table('flash_sale_products_view')
        //     ->orderBy('product_id','desc')
        //     ->get(['product_id','product_name']);




        // dd($products);
        $flash_end_date = FlashSale::first();

        return $dataTable->render('admin.flash-sale.index', compact('products', 'flash_end_date'));
    }


    public function end_date(Request $request)
    {

        $request->validate([
            'end_date' => 'required|date|after_or_equal:today',
        ]);
        // dd($request->all());

        $flashSaleEndDate = FlashSale::updateOrCreate(
            ['id' => '1'],// ?  this is the condition of update Or create ( if the id =1 the data with update if the id doesn't equal 1 they will create new row with id 1 )
            ['end_date' => $request->end_date]
        );


        $flashSaleItems = FlashSaleItem::where('flash_sale_id', null)->get();
        if (count($flashSaleItems) > 0) {
            foreach ($flashSaleItems as $item) {
                $item->update([
                    'flash_sale_id' => $flashSaleEndDate->id,//Or 1
                ]);
            }
        }

        toastr('End Date Is Updated Successfully', 'success', 'Success');

        return redirect()->back();
    }


    public function add_product(Request $request)
    {

        $request->validate([
            // 'product'=>['required','exists:products,id','numeric','unique:flash_sale_items,product_id'],
            'product' => [
                'required',
                'exists:flash_sale_products_view,product_id',
                'numeric',
                'unique:flash_sale_items,product_id'
            ],
            'status' => 'required',
            'show_at_home' => 'required'
        ], [
            'product.unique' => 'Product is already exists in the flash sale !',
        ]);

        // dd($request->all());

        $flash_end_date = FlashSale::first();

        $flashSaleItem = new FlashSaleItem();
        $flashSaleItem->flash_sale_id = optional($flash_end_date)->id;
        $flashSaleItem->product_id = $request->product;
        $flashSaleItem->show_at_home = $request->show_at_home;
        $flashSaleItem->status = $request->status;
        $flashSaleItem->save();


        toastr('Product Is Added Successfully To Flash Sale', 'success', 'Success');

        return redirect()->back();

    }


    public function destroy(string $id)
    {
        try {

            $flash_item = FlashSaleItem::find($id);

            if (!$flash_item) {
                return response(['status' => 'error', 'message' => 'flash item is not found!']);
            }

            $flash_item->delete();

            // we are using ajax : 
            return response(['status' => 'success', 'message' => " Product Has Been Deleted From The Flash Sale Successfully !"]);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:flash_sale_items,id',
            'status' => 'required|in:true,false',
        ]);

        $flash_item = FlashSaleItem::find($request->id);


        if (!$flash_item) {

            return response(['status' => 'error', 'message' => 'Flash sale item is not found!']);
            // return redirect()->back();
        }

        $product_name = $flash_item->product->name;


        $flash_item->status = $request->status == 'true' ? 1 : 0;

        $flash_item->save();

        $status = ($flash_item->status == 1) ? 'activated' : 'deactivated';

        return response(['status' => 'success', 'message' => "The $product_name has been $status in the flash sale"]);


    }


    public function change_at_home_status(Request $request)
    {
        $flash_item = FlashSaleItem::find($request->id);


        if (!$flash_item) {

            toastr()->error('Item is not found!');
            return to_route('admin.flash-sale.index');
            // return redirect()->back();
        }

        $product_name = $flash_item->product->name;


        $flash_item->show_at_home = $request->show_at_home_status == 'true' ? 1 : 0;

        $flash_item->save();

        $status = ($flash_item->show_at_home == 1) ? 'show it' : 'don\'t show it ';

        return response(['status' => 'success', 'message' => "The $product_name has been $status at the flash sale in the home page"]);


    }
}
