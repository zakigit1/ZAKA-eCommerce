<?php

namespace App\Http\Controllers\Backend\Admin\Footer;

use App\DataTables\FooterSocialsDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class FooterSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterSocialsDataTable $dataTable)
    {
        return $dataTable->render('admin.footer.footer-socials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-socials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        try{
            $this->validate($request, [
                'icon'=> ['required','not_in:empty'],
                'name'=> 'required|string|max:200|unique:footer_socials,name',
                'url'=> 'required|url',
                'status'=> 'required|boolean',
            ]);

            $footerSocial = new FooterSocial();
    
            $footerSocial->icon = $request->icon ;
            $footerSocial->name = $request->name ;
            $footerSocial->url = $request->url ;
            $footerSocial->status = $request->status ;
    
            $footerSocial->save();
    
            
            Cache::forget('footer_socials');

            toastr('Footer Social created Successfully !','success','Success');
            return redirect()->route('admin.footer-socials.index');

        } catch (ValidationException $e) {
            toastr()->error($e->getMessage(),'Error Footer Social');
           return redirect()->route('admin.footer-socials.index');
            
        } catch (\Exception $ex) {
            
            toastr()->error($ex->getMessage(),'Error Footer Social');
           return redirect()->route('admin.footer-socials.index');
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $footerSocial = FooterSocial::find($id);

        if(!$footerSocial){
            toastr('Footer Social Not Found !','error','Error Footer Social');
            return redirect()->route('admin.footer-socials.index');
        }

        return view('admin.footer.footer-socials.edit',compact('footerSocial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try{
            $this->validate($request, [
                'icon'=> ['required','not_in:empty'],
                'name' => 'required|string|max:200|unique:footer_socials,name,'.$id,
                'url'=> 'required|url',
                'status'=> 'required|boolean',
    
            ]);

            $footerSocial = FooterSocial::find($id);
    
            if(!$footerSocial){
                toastr('Footer Social Not Found !','error','Error Footer Social');
                return redirect()->route('admin.footer-socials.index');
            }
    
            $updateFooterSocial = $footerSocial->update($request->except(['submit','_method','_token']));
    
            Cache::forget('footer_socials');
    
            toastr('Footer Social Updated Successfully !','success','Success');
            return redirect()->route('admin.footer-socials.index');

        } catch (ValidationException $e) {

            toastr()->error($e->getMessage(),'Error Footer Social');
            return redirect()->route('admin.footer-socials.index');
            
        } catch (\Exception $ex) {
            
            toastr()->error($ex->getMessage(),'Error Footer Social');
            return redirect()->route('admin.footer-socials.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $footerSocial = FooterSocial::find($id);

            if(!$footerSocial){
                return response(['status'=>'error','message'=>'Footer Social is not found!']);
            }

            $footerSocial->delete();

            Cache::forget('footer_socials');
            // we are using ajax : 
            return response(['status'=>'success','message'=>"Footer Social Has Been Deleted Successfully !"]);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>$e->getMessage()]);
            // return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }


    public function change_status(Request $request)
    {   
        try{
            $request->validate([
                'id'=>'required|exists:footer_socials,id',
                'status' => 'required|in:true,false',
            ]);

            $footerSocial =FooterSocial::find($request->id);
    
            if(!$footerSocial){
                return response(['status'=>'error','message'=>'Footer Social is not found!']);
            }
    
           
            $footerSocial->status = $request->status == 'true' ? 1 : 0;
             
            $footerSocial->save();
    
            $status =($footerSocial->status == 1) ? 'activated' : 'deactivated';
    
            Cache::forget('footer_socials');
    
            return response(['status'=>'success','message'=>"The Footer Social  has been $status"]);
            
        } catch (ValidationException $e) {
            return response(['status'=>'error','message'=>$e->getMessage()]);
            
        } catch (\Exception $ex) {
            return response(['status'=>'error','message'=>$ex->getMessage()]);
        }
    }
}
