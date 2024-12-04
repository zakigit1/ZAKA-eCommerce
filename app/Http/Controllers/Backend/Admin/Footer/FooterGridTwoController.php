<?php

namespace App\Http\Controllers\Backend\Admin\Footer;

use App\DataTables\FooterGridTwoDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterGridTwo;
use App\Models\FooterTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class FooterGridTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterGridTwoDataTable $dataTable)
    {
        $footerGridTwoTitle = FooterTitle::first()->footer_grid_two_title;
        return $dataTable->render('admin.footer.footer-grid-two.index',compact('footerGridTwoTitle'));
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
        
        try{
            $this->validate($request, [
                'name'=> 'required|string|max:200|unique:footer_grid_twos,name',
                'url'=> 'required|url',
                'status'=> 'required|boolean',
            ]);
            
            $footerGridTwo = new FooterGridTwo();
    
            
            $footerGridTwo->name = $request->name ;
            $footerGridTwo->url = $request->url ;
            $footerGridTwo->status = $request->status ;
    
            $footerGridTwo->save();
    
            Cache::forget('footer_grid_two_links');
    
            toastr('Footer Grid Two created Successfully !','success','Success');
            return redirect()->route('admin.footer-grid-two.index');
            
        
        } catch (ValidationException $e) {
            toastr()->error($e->getMessage(),'Error Footer Grid Two');
            return redirect()->route('admin.footer-grid-two.index');
            
        } catch (\Exception $ex) {
            
            toastr()->error($ex->getMessage(),'Error Footer Grid Two');
            return redirect()->route('admin.footer-grid-two.index');
        }



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
        
        
        try{
            $this->validate($request, [
    
                'name' => 'required|string|max:200|unique:footer_grid_twos,name,'.$id,
                'url'=> 'required|url',
                'status'=> 'required|boolean',
    
            ]);

            $footerGridTwo = FooterGridTwo::find($id);
    
            if(!$footerGridTwo){
                toastr('Footer Grid Two Not Found !','error','Error Footer Grid Two');
                return redirect()->route('admin.footer-grid-two.index');
            }
    
            $updateFooterGridTwo = $footerGridTwo->update($request->except(['submit','_method','_token']));
    
            Cache::forget('footer_grid_two_links');
            
            toastr('Footer Grid Two Updated Successfully !','success','Success');
            return redirect()->route('admin.footer-grid-two.index');

        } catch (ValidationException $e) {

            toastr()->error($e->getMessage(),'Error Footer Grid Two');
           return redirect()->route('admin.footer-grid-two.index');
            
        } catch (\Exception $ex) {
            
            toastr()->error($ex->getMessage(),'Error Footer Grid Two');
           return redirect()->route('admin.footer-grid-two.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $footerGridTwo = FooterGridTwo::find($id);

            if(!$footerGridTwo){
                return response(['status'=>'error','message'=>'Footer Part (grid) two is not found!']);
            }


            $footerGridTwo->delete();
            
            Cache::forget('footer_grid_two_links');

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Footer Grid Two Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>$e->getMessage()]);
            // return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }



    public function change_status(Request $request)
    {
        
        try{
            $request->validate([
                'id'=>'required|exists:footer_grid_twos,id',
                'status' => 'required|in:true,false',
            ]);

            $footerGridTwo = FooterGridTwo::find($request->id);
    
            if(!$footerGridTwo){
                return response(['status'=>'error','message'=>'Footer part two is not found!']);
            }
    
           
            $footerGridTwo->status = $request->status == 'true' ? 1 : 0;
             
            $footerGridTwo->save();
    
            $status =($footerGridTwo->status == 1) ? 'activated' : 'deactivated';
    
            Cache::forget('footer_grid_two_links');
    
            return response(['status'=>'success','message'=>"The Footer Grid Two  has been $status"]);
        } catch (ValidationException $e) {
            return response(['status'=>'error','message'=>$e->getMessage()]);
            
        } catch (\Exception $ex) {
            return response(['status'=>'error','message'=>$ex->getMessage()]);
        }

       
    }



    public function changeTitle(Request $request)
    {
        try{
            $request->validate([
                'title' => 'required|max:200'
            ]);

            FooterTitle::updateOrCreate(
                ['id' => 1],
                [
                    'footer_grid_two_title' => $request->title,
                ]
            );
    
            Cache::forget('footer_title');
    
            toastr('Footer Grid Two Title Has Been Updated Successfully !','success','Success');
            return redirect()->back();

        } catch (ValidationException $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
            
        } catch (\Exception $ex) {
            toastr()->error($ex->getMessage());
            return redirect()->back();
        }



    }


}
