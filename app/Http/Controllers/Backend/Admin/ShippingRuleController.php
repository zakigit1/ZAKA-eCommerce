<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\ShippingRulesDataTable;
use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRulesDataTable $dataTable )
    {
        return $dataTable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('admin.shipping-rule.create');  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'  => 'required|max:200' ,
            'type' => 'required|string' ,
            'min_cost' => 'nullable|numeric|integer' ,
            'cost' => 'required|numeric|integer' ,
            'status' => 'required|boolean' ,
        ]);
        
        // dd($request->all());
        try{

            $shippingRule = new ShippingRule();
            $shippingRule->name  = $request-> name;
            $shippingRule->type  = $request-> type;
            $shippingRule->min_cost  = $request->min_cost;
            $shippingRule->cost  = $request->cost ;
            $shippingRule->status  = $request->status ;

            $shippingRule->save();


            toastr('shipping rule Has Been Created Successfully !');
            return redirect()->route('admin.shipping-rules.index');

        }catch(\Exception $ex){
            toastr('shipping rule Has Not Been Created Successfully !');
            return redirect()->route('admin.shipping-rules.index');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shippingRule = ShippingRule::findOrFail($id);
        return view('admin.shipping-rule.edit',compact('shippingRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => 'required|max:200' ,
            'type' => 'required|string' ,
            'min_cost' => 'nullable|numeric|integer' ,
            'cost' => 'required|numeric|integer' ,
            'status' => 'required|boolean' ,
        ]);
        // dd($request->all());

        try{

            $shippingRule = ShippingRule::findOrFail($id);
            $shippingRule->name  = $request-> name;
            $shippingRule->type  = $request-> type;
            $shippingRule->min_cost  = $request->min_cost;
            $shippingRule->cost  = $request->cost ;
            $shippingRule->status  = $request->status ;

            $shippingRule->save();


            toastr('shipping rule Has Been Updated Successfully !');
            return redirect()->route('admin.shipping-rules.index');

        }catch(\Exception $ex){
            toastr('shipping rule Has Not Been Updated Successfully !');
            return redirect()->route('admin.shipping-rules.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $shippingRule = ShippingRule::find($id);

            if(!$shippingRule){
                return response(['status'=>'error','message'=>'Shipping Rule is not found!']);
            }

            $shippingRule->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Shipping Rule Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }



    public function change_status(Request $request)
    {

        $shippingRule = ShippingRule::find($request->id);

        if(!$shippingRule){
            return response(['status'=>'error','message'=>'Shipping rule is not found!']);
        }

       
        $shippingRule->status = $request->status == 'true' ? 1 : 0;
         
        $shippingRule->save();

        $status =($shippingRule->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Shipping Rule ( $shippingRule->name ) has been $status"]);

       
    }
}
