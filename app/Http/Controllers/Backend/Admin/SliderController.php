<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Traits\imageUploadTrait;
use App\DataTables\SlidersDataTable;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    use imageUploadTrait;


    /**
     * Display a listing of the resource.
     */
    public function index(SlidersDataTable $dataTable)
    {
        // return $dataTable->render('Admin.slider.index');
        return $dataTable->render('admin.slider.index');
        // return view('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
        /** Validation Part :  */
    
        $this->validate($request, [
            'banner'=> 'required|image',
            'type'=> 'nullable|string|max:200',
            'title'=> 'required|max:200',
            'starting_price'=> 'nullable|numeric|min:0|max:1000',
            'btn_url'=> 'url',
            'serial'=> 'required|integer',
            'status'=> 'required|boolean',
        ]);

        // return $request;
        // return dd($request->all());


        try{
            /** Image Part BEGIN   */ 
            //note : we are saving image into db with other info because field image is required 


            ###### We add if condition for secure only because we are already use required in validation

            // $imageName='';
            // if($request->hasFile('banner')){

            //     $Folder_name='sliders';
                
            //     // store the image in storage folder
            //     $imageName= uploadImageNew($request->banner,'/Uploads/images/'.$Folder_name);  
            // }


            ## using trait : 
            // $imageName='';
            // if($request->hasFile('banner')){

            //     $imageName= $this->uploadImage_Trait($request,'banner','/Uploads/images/','sliders');

            // }

            
            $imageName= $this->uploadImage_Trait($request,'banner','/Uploads/images/','sliders');

            /** Image Part END   */ 




            /** insert info Part in to DB :  */

            $slider =Slider::create([
                'banner'=>$imageName,
                'type'=> $request->type,
                'title'=> $request->title,
                'starting_price'=>$request->starting_price,
                'btn_url'=>$request->btn_url,
                'serial'=>$request->serial,
                'status'=>$request->status,
            ]);

            toastr()->success('Slider Created Successfully !');
            return redirect()->route('admin.slider.index');

        }catch(\Exception $e){
            
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.slider.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::find($id);

        if(!$slider){
            toastr()->error( 'slider is not found!');
            return to_route('admin.slider.index');
        }


        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        /** Validation Part :  */
    
        $this->validate($request, [

            // 'banner'=> 'required_without:id|image',
            'banner'=> 'nullable|image',
            'type'=> 'nullable|string|max:200',
            'title'=> 'required|max:200',
            'starting_price'=> 'nullable|numeric|min:0|max:1000',
            'btn_url'=> 'url',
            'serial'=> 'required|integer',
            'status'=> 'required|boolean',
        ]);


        // return $request;
        // dd($request->all());

        try{

            $slider =Slider::find($id);

            if(!$slider){
                toastr()->error( 'slider is not found!');
                return to_route('admin.slider.index');
            }

            /** Image Part BEGIN   */ 
            
            

          

            if($request->hasFile('banner')){

                
                $Folder_name='sliders';

                $old_image = $slider->banner;

                // delete the old image
                deleteImage($old_image);

                // store the image in storage folder
                $imageName= uploadImageNew($request->banner,'/Uploads/images/',$Folder_name);  

                DB::beginTransaction();
                ## Save Image In To DataBase : 
                Slider::where('id',$id)->update([
                    'banner'=>$imageName,
                ]);
            }

            /** Image Part END   */ 
   


            /** Update info Part in to DB :  */

            Slider::where('id', $id)->update($request->except(['_token','banner','_method','submit']));

            // $slider_updated =Slider::where('id', $id)->update($request->only([
            //     'type',
            //     'title',
            //     'starting_price',
            //     'btn_url',
            //     'serial',
            //     'status',
            // ]));


            toastr()->success('Slider Updated Successfully !');


            DB::commit();
            return redirect()->route('admin.slider.index');

        }catch(\Exception $e){
            
            DB::rollback();
            toastr()->error( 'حدث خطا ما برجاء المحاوله لاحقا');
            return redirect()->route('admin.slider.index');
        }







    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{ 

            $slider = Slider::find($id);

            if(!$slider){
                return response(['status'=>'error','message'=>'Slider is not found!']);
            }

            deleteImage($slider->banner);

            $slider->delete();

            // we are using ajax : 
            return response(['status'=>'success','message'=>'Slider Deleted Successfully !']);
        }catch(\Exception $e){
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }   
}