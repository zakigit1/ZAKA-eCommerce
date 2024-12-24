<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\CouponsDataTable;
use App\Models\Coupon;
use Illuminate\Http\Request;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponsDataTable $dataTable )
    {
       
        return $dataTable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

 
        $request->validate([
            'name' => 'required|max:200' ,
            'code' => 'required|max:200' ,
            'quantity' => 'required|numeric|integer' ,
            'max_use' => 'required|numeric|integer' ,
            'start_date' => 'required|date' ,
            'end_date' => 'required|date' ,
            'discount_type' => 'required' ,
            'discount' => 'required' ,
            'status' => 'required|boolean' ,

        ]);
        // dd($request->all());

        try{

            $coupon = new Coupon();
            $coupon->name  = $request->name ;
            $coupon->code  = $request->code ;
            $coupon->quantity  = $request->quantity ;
            $coupon->max_use  = $request->max_use ;
            $coupon->start_date  = $request->start_date ;
            $coupon->end_date  = $request->end_date ;
            $coupon->discount_type  = $request->discount_type ;
            $coupon->discount  = $request->discount ;
            $coupon->total_used  = 0 ;
            $coupon->status = $request->status ;
            $coupon->save();


            toastr('Coupon Has Been Created Successfully !');
            return redirect()->route('admin.coupons.index');

        }catch(\Exception $ex){
            toastr('Coupon Has Not Been Created Successfully !');
            return redirect()->route('admin.coupons.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:200' ,
            'code' => 'required|max:200' ,
            'quantity' => 'required|numeric|integer' ,
            'max_use' => 'required|numeric|integer' ,
            'start_date' => 'required|date' ,
            'end_date' => 'required|date' ,
            'discount_type' => 'required' ,
            'discount' => 'required' ,
            'status' => 'required|boolean' ,

        ]);
        // dd($request->all());

        try{

            $coupon = Coupon::findOrFail($id);
            
            $coupon->name  = $request->name ;
            $coupon->code  = $request->code ;
            $coupon->quantity  = $request->quantity ;
            $coupon->max_use  = $request->max_use ;
            $coupon->start_date  = $request->start_date ;
            $coupon->end_date  = $request->end_date ;
            $coupon->discount_type  = $request->discount_type ;
            $coupon->discount  = $request->discount ;
            $coupon->status = $request->status ;
            $coupon->save();

            toastr('Coupon Has Been Updated Successfully !');
            return redirect()->route('admin.coupons.index');

        }catch(\Exception $ex){
            toastr('Coupon Has Not Been Updated Successfully !');
            return redirect()->route('admin.coupons.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $coupon = Coupon::find($id);

            if(!$coupon){
                return response(['status'=>'error','message'=>'Coupon is not found!']);
            }

            $coupon_name =$coupon->name;


            $coupon->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Coupon Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }



    public function change_status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:coupons,id',
            'status' => 'required|in:true,false',
        ]);
        
        $coupon = Coupon::find($request->id);

        if(!$coupon){
            return response(['status'=>'error','message'=>'Coupon is not found!']);
        }

       
        $coupon->status = $request->status == 'true' ? 1 : 0;
         
        $coupon->save();

        $status =($coupon->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Coupon ( $coupon->name ) has been $status"]);

       
    }
}
