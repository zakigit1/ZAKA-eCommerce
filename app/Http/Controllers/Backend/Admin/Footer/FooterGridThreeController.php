<?php

namespace App\Http\Controllers\Backend\Admin\Footer;

use App\DataTables\FooterGridThreeDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterGridThree;
use App\Models\FooterTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class FooterGridThreeController extends Controller
{
    public function index(FooterGridThreeDataTable $dataTable)
    {
        $footerGridThreeTitle = FooterTitle::first()->footer_grid_three_title;

        return $dataTable->render('admin.footer.footer-grid-three.index',compact('footerGridThreeTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-grid-three.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'name'=> 'required|string|max:200|unique:footer_grid_threes,name',
                'url'=> 'required|url',
                'status'=> 'required|boolean',
            ]);

            $footerGridThree = new FooterGridThree();
    
            
            $footerGridThree->name = $request->name ;
            $footerGridThree->url = $request->url ;
            $footerGridThree->status = $request->status ;
    
            $footerGridThree->save();
    
            //remove cache
            Cache::forget('footer_grid_three_links');

            toastr('Footer Grid Three$footerGridThree created Successfully !','success','Success');
            return redirect()->route('admin.footer-grid-three.index');


        } catch (ValidationException $e) {
            toastr()->error($e->getMessage(),'Error Footer Grid Three');
            return redirect()->route('admin.footer-grid-three.index');
            
        } catch (\Exception $ex) {
            
            toastr()->error($ex->getMessage(),'Error Footer Grid Three');
            return redirect()->route('admin.footer-grid-three.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $footerGridThree = FooterGridThree::find($id);

        if(!$footerGridThree){
            toastr('Footer Grid Three Not Found !','error','Error Footer Grid Three');
            return redirect()->route('admin.footer-grid-three.index');
        }

        return view('admin.footer.footer-grid-three.edit',compact('footerGridThree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $this->validate($request, [
    
                'name' => 'required|string|max:200|unique:footer_grid_threes,name,'.$id,
                'url'=> 'required|url',
                'status'=> 'required|boolean',
    
            ]);
            
            $footerGridThree = FooterGridThree::find($id);
    
            if(!$footerGridThree){
                toastr('Footer Grid Three Not Found !','error','Error Footer Grid Three');
                return redirect()->route('admin.footer-grid-three.index');
            }
    
            $updateFooterGridThree = $footerGridThree->update($request->except(['submit','_method','_token']));
    
            Cache::forget('footer_grid_three_links');

            toastr('Footer Grid Three Updated Successfully !','success','Success');
            return redirect()->route('admin.footer-grid-three.index');

        } catch (ValidationException $e) {

            toastr()->error($e->getMessage(),'Error Footer Grid Three');
            return redirect()->route('admin.footer-grid-three.index');
            
        } catch (\Exception $ex) {
            
            toastr()->error($ex->getMessage(),'Error Footer Grid Three');
            return redirect()->route('admin.footer-grid-three.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $footerGridThree = FooterGridThree::find($id);

            if(!$footerGridThree){
                return response(['status'=>'error','message'=>'Footer Part (grid) three is not found!']);
            }


            $footerGridThree->delete();

            Cache::forget('footer_grid_three_links');

            // we are using ajax : 
            return response(['status'=>'success','message'=>"Footer Grid Three Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>$e->getMessage()]);
            // return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }



    public function change_status(Request $request)
    {
        
        try{
            $request->validate([
                'id'=>'required|exists:footer_grid_threes,id',
                'status' => 'required|in:true,false',
            ]);
            
            $footerGridThree = FooterGridThree::find($request->id);
    
            if(!$footerGridThree){
                return response(['status'=>'error','message'=>'Footer part three is not found!']);
            }
    
            
            $footerGridThree->status = $request->status == 'true' ? 1 : 0;
                
            $footerGridThree->save();
    
            $status =($footerGridThree->status == 1) ? 'activated' : 'deactivated';

            Cache::forget('footer_grid_three_links');

            return response(['status'=>'success','message'=>"The Footer Grid Three  has been $status"]);
            
        
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
                    'footer_grid_three_title' => $request->title,
                ]
            );
            
            Cache::forget('footer_title');

            toastr('Footer Grid Three Title Has Been Updated Successfully !','success','Success');
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
