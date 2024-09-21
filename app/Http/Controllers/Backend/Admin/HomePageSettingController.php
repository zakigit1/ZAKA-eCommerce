<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\HomePageSetting;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class HomePageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::active()->get(['id','name']);
        return view('admin.home-page-setting.index',compact('categories'));
    }


    // AJAX 
    public function get_subcategories(Request $request){


        $subcategories = Subcategory::where('category_id',$request->category_id)->active()->get(['id','name']);
        // $subcategories = Subcategory::where('category_id',$request->id)->active()->get();

        return $subcategories;

    }
    public function get_childcategories(Request $request){

        $childcategories = Childcategory::where('sub_category_id',$request->sub_category_id)->active()->get(['id','name']);
        

        return $childcategories;

    }



    /**
     * Update the specified resource in storage.
     */
    public function UpdatePopularCategory(Request $request)
    {
        // dd($request->all());

        $data =[
            [
                'category'=>$request->cat_one,
                'sub_category'=>$request->sub_cat_one,
                'child_category'=>$request->child_cat_one,
            ],
            [
                'category'=>$request->cat_two,
                'sub_category'=>$request->sub_cat_two,
                'child_category'=>$request->child_cat_two,
            ],
            [
                'category'=>$request->cat_three,
                'sub_category'=>$request->sub_cat_three,
                'child_category'=>$request->child_cat_three,
            ],
            [
                'category'=>$request->cat_four,
                'sub_category'=>$request->sub_cat_four,
                'child_category'=>$request->child_cat_four,
            ],
        ];



        $update = HomePageSetting::updateOrCreate(
            [
                'key'=>'popular_category_section'
            ],
            [
                'value'=>json_encode($data)
            ]
        );

        toastr('Popular Category Section Has Been Updated Successfully !','success','Success');
        return redirect()->back();
    }


}
