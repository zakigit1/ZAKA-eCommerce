<?php

namespace App\Http\Controllers\Backend\Admin\Footer;

use App\DataTables\FooterGridTwoDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterGridTwo;
use App\Models\FooterTitle;
use Illuminate\Http\Request;

class FooterGridTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterGridTwoDataTable $dataTable)
    {
        $footerGridTwoTitle = FooterTitle::first()->footer_grid_two_title;
        return $dataTable->render('admin.footer.footer-grid-two.index',compact('footerTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-grid-two.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|string|max:200|unique:footer_grid_twos,name',
            'url'=> 'required|url',
            'status'=> 'required|boolean',
        ]);

        // dd($request->all());

        $footerGridTwo = new FooterGridTwo();

        
        $footerGridTwo->name = $request->name ;
        $footerGridTwo->url = $request->url ;
        $footerGridTwo->status = $request->status ;

        $footerGridTwo->save();

        toastr('Footer Grid Two created Successfully !','success','Success');
        return redirect()->route('admin.footer-grid-two.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $footerGridTwo = FooterGridTwo::find($id);

        if(!$footerGridTwo){
            toastr('Footer Grid Two Not Found !','error','Error Footer Grid Two');
            return redirect()->route('admin.footer-grid-two.index');
        }

        return view('admin.footer.footer-grid-two.edit',compact('footerGridTwo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [

            'name' => 'required|string|max:200|unique:footer_grid_twos,name,'.$id,
            'url'=> 'required|url',
            'status'=> 'required|boolean',

        ]);

        // dd($request->all());

        $footerGridTwo = FooterGridTwo::find($id);

        if(!$footerGridTwo){
            toastr('Footer Grid Two Not Found !','error','Error Footer Grid Two');
            return redirect()->route('admin.footer-grid-two.index');
        }

        $updateFooterGridTwo = $footerGridTwo->update($request->except(['submit','_method','_token']));


        toastr('Footer Grid Two Updated Successfully !','success','Success');
        return redirect()->route('admin.footer-grid-two.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $footerGridTwo = FooterGridTwo::find($id);

            if(!$footerGridTwo){
                toastr('Footer Grid Two Not Found !','error','Error Footer Grid Two');
                return redirect()->route('admin.footer-grid-two.index');
            }


            $footerGridTwo->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Footer Grid Two Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }



    public function change_status(Request $request)
    {
        $footerGridTwo = FooterGridTwo::find($request->id);

        if(!$footerGridTwo){
            toastr('Footer Grid Two Not Found !','error','Error Footer Grid Two');
            return redirect()->route('admin.footer-grid-two.index');
        }

       
        $footerGridTwo->status = $request->status == 'true' ? 1 : 0;
         
        $footerGridTwo->save();

        $status =($footerGridTwo->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Footer Grid Two  has been $status"]);

       
    }



    public function changeTitle(Request $request){
        $request->validate([
            'title' => 'required|max:200'
        ]);

        // dd($request->all());

        FooterTitle::updateOrCreate(
            ['id' => 1],
            [
                'footer_grid_two_title' => $request->title,
            ]
        );

        toastr('Footer Grid Two Title Has Been Updated Successfully !','success','Success');
        return redirect()->back();
    }


}
