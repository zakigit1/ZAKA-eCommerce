<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\WithdrawMethodDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WithdrawMethodDataTable $dataTable)
    {
        return $dataTable->render('admin.withdraw-method.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.withdraw-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'minimum_amount' => 'required|numeric|lt:maximum_amount',
                'maximum_amount' => 'required|numeric|gt:minimum_amount',
                'withdraw_charge' => 'required|numeric',
                'description' => 'required|max:1000',
            ]);


            $withdrawMethod = new WithdrawMethod() ;
            $withdrawMethod->name = $request->name ;
            $withdrawMethod->minimum_amount = $request->minimum_amount ;
            $withdrawMethod->maximum_amount = $request->maximum_amount ;
            $withdrawMethod->withdraw_charge = $request->withdraw_charge ;
            $withdrawMethod->description = $request->description ;
            $withdrawMethod->save() ;

            toastr('Withdraw Method Has Been Created Successfully!','success','Success');
            return redirect()->route('admin.withdraw-method.index');



        }catch(\Exception $e){
            toastr($e->getMessage(),'error','Error');
            // toastr('Something went wrong, please try again later.','error','Error');
            return redirect()->route('admin.withdraw-method.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $withdrawMethod = WithdrawMethod::find($id);

            if(!$withdrawMethod){
                toastr('Withdraw Method Not Found ! ','error');
                return redirect()->route('admin.withdraw-method.index');
            }
            return view('admin.withdraw-method.edit',compact('withdrawMethod'));
        }catch(\Exception $e){
            toastr($e->getMessage(),'error','Error');
            // toastr('Something went wrong, please try again later.','error','Error');
            return redirect()->route('admin.withdraw-method.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            // return $request->all();

            $request->validate([
                'name' => 'required|string|max:255',
                'minimum_amount' => 'required|numeric|lt:maximum_amount',
                'maximum_amount' => 'required|numeric|gt:minimum_amount',
                'withdraw_charge' => 'required|numeric',
                'description' => 'required|max:1000',
            ]);

            $withdrawMethod = WithdrawMethod::find($id);
    
    
            if(!$withdrawMethod){
                toastr('Withdraw Method Not Found ! ','error');
                return redirect()->route('admin.withdraw-method.index');
            }
            
            $withdrawMethod->name = $request->name ;
            $withdrawMethod->minimum_amount = $request->minimum_amount ;
            $withdrawMethod->maximum_amount = $request->maximum_amount ;
            $withdrawMethod->withdraw_charge = $request->withdraw_charge ;
            $withdrawMethod->description = $request->description ;
            $withdrawMethod->save() ;

            toastr('Withdraw Method Has Been Updated Successfully!','success','Success');
            return redirect()->route('admin.withdraw-method.index');

        }catch(\Exception $e){
            toastr($e->getMessage(),'error','Error');
            // toastr('Something went wrong, please try again later.','error','Error');
            return redirect()->route('admin.withdraw-method.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        try{
            $withdrawMethod = WithdrawMethod::find($id);
    
    
            if(!$withdrawMethod){
                toastr('Withdraw Method Not Found ! ','error');
                return redirect()->route('admin.withdraw-method.index');
            }

            $withdrawMethod->delete() ;
            return response(['status'=>'success','message'=>"Withdraw Method Has Been Deleted successfully!"]);

        }catch(\Exception $e){

            return response(['status'=>'error','message'=>$e->getMessage()]);
            // return response(['status'=>'error','message'=>'Something went wrong, please try again later.']);
        }
    }
}
