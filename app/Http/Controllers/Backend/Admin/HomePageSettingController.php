<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\HomePageSetting;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session ;

class HomePageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories'] = Category::active()->get(['id','name']);

        $data['popularCategories'] = HomePageSetting::where('key','popular_category_section')->first();
        $data['popularCategories'] = json_decode(@$data['popularCategories']->value);

        $data['productSliderSectionOne'] = HomePageSetting::where('key','product_slider_section_one')->first();
        $data['productSliderSectionOne'] = json_decode(@$data['productSliderSectionOne']->value);

        
        // $cat_type =$this->checkTheLastKey($data['productSliderSectionOne']);// make some modification (i want to remove the category of the section one )
        // dd($cat_type);
        // $data['categories2'] = Category::where('id',"!=",$data['productSliderSectionOne']->$cat_type)->active()->get(['id','name']);
        
        $data['productSliderSectionTwo'] = HomePageSetting::where('key','product_slider_section_two')->first();
        $data['productSliderSectionTwo'] = json_decode(@$data['productSliderSectionTwo']->value);

        $data['weeklyBestProducts'] = HomePageSetting::where('key','weekly_best_products')->first();
        $data['weeklyBestProducts'] = json_decode(@$data['weeklyBestProducts']->value);

        
        // dd($data['weeklyBestProducts'][0]);
        // dd($data['productSliderSectionOne']->category);
        return view('admin.home-page-setting.index',$data);
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




    public function UpdatePopularCategory(Request $request)
    {

        $request->validate([
            'cat_1' => 'required|exists:categories,id',
            'cat_2' => 'required|exists:categories,id',
            'cat_3' => 'required|exists:categories,id',
            'cat_4' => 'required|exists:categories,id',
            
        ],[
            'cat_1.required' => 'The Category One Is Required',
            'cat_1.exists' => 'The Category One Does Not Exist',
            'cat_2.required' => 'The Category Two Is Required',
            'cat_2.exists' => 'The Category Two Does Not Exist',
            'cat_3.required' => 'The Category three Is Required',
            'cat_3.exists' => 'The Category three Does Not Exist',
            'cat_4.required' => 'The Category four Is Required',
            'cat_4.exists' => 'The Category four Does Not Exist',
        ]);
        

        // dd($request->all());

        /** M1 */
        // $data =[
        //     [
        //         'category'=>$request->cat_one,
        //         'sub_category'=>$request->sub_cat_one,
        //         'child_category'=>$request->child_cat_one,
        //     ],
        //     [
        //         'category'=>$request->cat_two,
        //         'sub_category'=>$request->sub_cat_two,
        //         'child_category'=>$request->child_cat_two,
        //     ],
        //     [
        //         'category'=>$request->cat_three,
        //         'sub_category'=>$request->sub_cat_three,
        //         'child_category'=>$request->child_cat_three,
        //     ],
        //     [
        //         'category'=>$request->cat_four,
        //         'sub_category'=>$request->sub_cat_four,
        //         'child_category'=>$request->child_cat_four,
        //     ],
        // ];

        


        /** M2 */
        $data = [];
        for($i=1 ; $i<=4 ; $i++){
            $data[] = [
                'category' => $request->{'cat_'.$i},
                'sub_category' => $request->{'sub_cat_'.$i},
                'child_category' => $request->{'child_cat_'.$i},
            ];
        };

        // dd($data);

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


    public function UpdateProductSliderSectionOne(Request $request){

        //   dd($request->all());
            $request->validate([
                'category' => 'required' ,
            ]);
    
            $data =[
                'category'=>$request->category,
                'sub_category'=>$request->sub_category,
                'child_category'=>$request->child_category,
            ];
    
            $update = HomePageSetting::updateOrCreate(
                [
                    'key'=>'product_slider_section_one'
                ],
                [
                    'value'=>json_encode($data)
                ]
            );
            toastr('Product Slider Section One Has Been Updated Successfully !','success','Success');
            return redirect()->back();
    }

    public function UpdateProductSliderSectionTwo(Request $request){

    //   dd($request->all());
        $request->validate([
            'category' => 'required' ,
        ]);

        $data =[
            'category'=>$request->category,
            'sub_category'=>$request->sub_category,
            'child_category'=>$request->child_category,
        ];

        $update = HomePageSetting::updateOrCreate(
            [
                'key'=>'product_slider_section_two'
            ],
            [
                'value'=>json_encode($data)
            ]
        );
        toastr('Product Slider Section Two Has Been Updated Successfully !','success','Success');
        return redirect()->back();
    }


    public function UpdateWeeklyBestProducts(Request $request)
    {

        // dd($request->all());
        
        $request->validate([
            'cat_1' => 'required|exists:categories,id',
            'cat_2' => 'required|exists:categories,id',
            
        ],[
            'cat_1.required' => 'The Category One Is Required',
            'cat_1.exists' => 'The Category One Does Not Exist',
            'cat_2.required' => 'The Category Two Is Required',
            'cat_2.exists' => 'The Category Two Does Not Exist',
        ]);
        

        $data =[
            [
                'category'=>$request->cat_1,
                'sub_category'=>$request->sub_cat_1,
                'child_category'=>$request->child_cat_1,
            ],
            [
                'category'=>$request->cat_2,
                'sub_category'=>$request->sub_cat_2,
                'child_category'=>$request->child_cat_2,
            ],

        ];

        

        // dd($data);

        $update = HomePageSetting::updateOrCreate(
            [
                'key'=>'weekly_best_products'
            ],
            [
                'value'=>json_encode($data)
            ]
        );

        toastr('Weekly Best Products Has Been Updated Successfully !','success','Success');
        return redirect()->back();
    }


    

    public function changeViewList(Request $request): void
    {
        Session::put('home_page_settings_view_list',$request->style);
    }



}
