<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AdvertisementController extends Controller
{

    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'banners';



    public function index(){

        $data['homepageBannerSectionOne'] = Advertisement::where('key','homepage_banner_section_one')->first();
        $data['homepageBannerSectionOne'] = json_decode($data['homepageBannerSectionOne']?->value);

        $data['homepageBannerSectionTwo'] = Advertisement::where('key','homepage_banner_section_two')->first();
        $data['homepageBannerSectionTwo'] = json_decode($data['homepageBannerSectionTwo']?->value);
        
        // dd($data['homepageBannerSectionTwo'][1]->banner) ;
        
        $data['homepageBannerSectionThree'] = Advertisement::where('key','homepage_banner_section_three')->first();
        $data['homepageBannerSectionThree'] = json_decode($data['homepageBannerSectionThree']?->value);

        // dd($data['homepageBannerSectionThree']) ;

        $data['homepageBannerSectionFour'] = Advertisement::where('key','homepage_banner_section_four')->first();
        $data['homepageBannerSectionFour'] = json_decode($data['homepageBannerSectionFour']?->value);

        $data['productpageBanner'] = Advertisement::where('key','productpage_banner')->first();
        $data['productpageBanner'] = json_decode($data['productpageBanner']?->value);
        
        $data['cartpageBanner'] = Advertisement::where('key','cartpage_banner')->first();
        $data['cartpageBanner'] = json_decode($data['cartpageBanner']?->value);

        $data['homepageBannerFlashSaleEndDate'] = Advertisement::where('key','homepage_banner_flash_sale_end_date')->first();
        $data['homepageBannerFlashSaleEndDate'] = json_decode($data['homepageBannerFlashSaleEndDate']?->value);

        $data['flashsaleseemoreBanner'] = Advertisement::where('key','flash_sale_see_more_banner')->first();
        $data['flashsaleseemoreBanner'] = json_decode($data['flashsaleseemoreBanner']?->value);



        return view('admin.advertisement.index',$data);
    }


    public function homepageBannerSectionOne(Request $request){

        // dd($request->all());

        $request->validate([
            'banner_image' =>['image'],
            'banner_url' => 'required'
        ]);

        $bannerOne = Advertisement::where('key','homepage_banner_section_one')->first();
        $bannerOne = json_decode(@$bannerOne->value, true);

        

        // This condition is for the first time you want to enter banner .
        if($bannerOne == null && !$request->hasFile('banner_image')){
            toastr('You Must Enter For The First Time A Banner Image !','error','Error');
            return redirect()->back();
        }

        
        $oldBanner = $bannerOne['banner_image'] ?? null;

        $imageUpdatedPath = $oldBanner ;
        
        
        if($request->hasFile('banner_image')){

            $imageUpdatedName = $this->updateImage_Trait($request,'banner_image',AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

            $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
            
        }



        $data = [
            'banner_image' => $imageUpdatedPath,
            'banner_url' => $request->banner_url,
            'status' => ($request->status == 'on' ? 1 : 0),
        ] ;

        Advertisement::updateOrCreate(
            [
                'key'=>'homepage_banner_section_one'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Homepage Banner Section One Updated Successfully !','success','Success');
        return redirect()->back();

    }


    public function homepageBannerSectionTwo(Request $request){

        // dd($request->all());

        $request->validate([
            'banner_image_1' =>['image'],
            'banner_url_1' => 'required',
            'banner_image_2' =>['image'],
            'banner_url_2' => 'required',
        ]);


        $banners = Advertisement::where('key','homepage_banner_section_two')->first();
        $banners = json_decode(@$banners->value);
        
            
        // This condition is for the first time you want to enter banner .
        if($banners == null && !$request->hasFile("banner_image_1") && !$request->hasFile("banner_image_2")){
            toastr('You Must Enter For The First Time A Banner Images !','error','Error');
            return redirect()->back();
        }

        // dd($banners);


        for($i = 1; $i <=2; $i++){

           
            
            $oldBanner = $banners[$i-1]->{'banner_'.$i}->{'banner_image_'.$i} ?? null;

            $imageUpdatedPath = $oldBanner ;
            
            
            if($request->hasFile("banner_image_$i")){

                $imageUpdatedName = $this->updateImage_Trait($request,"banner_image_$i",AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

                $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
                
            }



                $data [] = [
                    "banner_$i"=>[
                        "banner_image_$i" => $imageUpdatedPath,
                        "banner_url_$i" => $request->{'banner_url_'.$i},
                    ]
                ] ;

        }

       
        $data [] =[
            'status'=>($request->status == 'on' ? 1 : 0)
        ];

        

        Advertisement::updateOrCreate(
            [
                'key'=>'homepage_banner_section_two'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Homepage Banner Section Two Updated Successfully !','success','Success');
        return redirect()->back();

    }

    
    public function homepageBannerSectionThree(Request $request){
        $request->validate([
            'banner_image_1' =>['image'],
            'banner_url_1' => 'required',
            'banner_image_2' =>['image'],
            'banner_url_2' => 'required',
            'banner_image_3' =>['image'],
            'banner_url_3' => 'required',
        ]);


        $banners = Advertisement::where('key','homepage_banner_section_three')->first();
        $banners = json_decode(@$banners->value);
        
            
        // This condition is for the first time you want to enter banner .
        if($banners == null && !$request->hasFile("banner_image_1") && !$request->hasFile("banner_image_2") && !$request->hasFile("banner_image_3")){
            toastr('You Must Enter For The First Time A Banner Images !','error','Error');
            return redirect()->back();
        }

        // dd($banners);


        for($i = 1; $i <=3; $i++){

           
            
            $oldBanner = $banners[$i-1]->{'banner_'.$i}->{'banner_image_'.$i} ?? null;

            $imageUpdatedPath = $oldBanner ;
            
            
            if($request->hasFile("banner_image_$i")){

                $imageUpdatedName = $this->updateImage_Trait($request,"banner_image_$i",AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

                $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
                
            }



                $data [] = [
                    "banner_$i"=>[
                        "banner_image_$i" => $imageUpdatedPath,
                        "banner_url_$i" => $request->{'banner_url_'.$i},
                    ]
                ] ;

        }

       
        $data [] =[
            'status'=>($request->status == 'on' ? 1 : 0)
        ];

        

        Advertisement::updateOrCreate(
            [
                'key'=>'homepage_banner_section_three'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Homepage Banner Section Three Updated Successfully !','success','Success');
        return redirect()->back();

    }


    public function homepageBannerSectionFour(Request $request){

        $request->validate([
            'banner_image' =>['image'],
            'banner_url' => 'required'
        ]);

        $bannerOne = Advertisement::where('key','homepage_banner_section_four')->first();
        $bannerOne = json_decode(@$bannerOne->value, true);

        

        // This condition is for the first time you want to enter banner .
        if($bannerOne == null && !$request->hasFile('banner_image')){
            toastr('You Must Enter For The First Time A Banner Image !','error','Error');
            return redirect()->back();
        }

        
        $oldBanner = $bannerOne['banner_image'] ?? null;

        $imageUpdatedPath = $oldBanner ;
        
        
        if($request->hasFile('banner_image')){

            $imageUpdatedName = $this->updateImage_Trait($request,'banner_image',AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

            $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
            
        }



        $data = [
            'banner_image' => $imageUpdatedPath,
            'banner_url' => $request->banner_url,
            'status' => ($request->status == 'on' ? 1 : 0),
        ] ;

        Advertisement::updateOrCreate(
            [
                'key'=>'homepage_banner_section_four'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Homepage Banner Section Four Updated Successfully !','success','Success');
        return redirect()->back();






    }


    public function productpageBanner(Request $request){

        $request->validate([
            'banner_image' =>['image'],
            'banner_url' => 'required'
        ]);

        $bannerOne = Advertisement::where('key','productpage_banner')->first();
        $bannerOne = json_decode(@$bannerOne->value, true);

        

        // This condition is for the first time you want to enter banner .
        if($bannerOne == null && !$request->hasFile('banner_image')){
            toastr('You Must Enter For The First Time A Banner Image !','error','Error');
            return redirect()->back();
        }

        
        $oldBanner = $bannerOne['banner_image'] ?? null;

        $imageUpdatedPath = $oldBanner ;
        
        
        if($request->hasFile('banner_image')){

            $imageUpdatedName = $this->updateImage_Trait($request,'banner_image',AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

            $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
            
        }



        $data = [
            'banner_image' => $imageUpdatedPath,
            'banner_url' => $request->banner_url,
            'status' => ($request->status == 'on' ? 1 : 0),
        ] ;

        Advertisement::updateOrCreate(
            [
                'key'=>'productpage_banner'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Productpage Banner Updated Successfully !','success','Success');
        return redirect()->back();

    }


    public function cartpageBanner(Request $request){

        $request->validate([
            'banner_image_1' =>['image'],
            'banner_url_1' => 'required',
            'banner_image_2' =>['image'],
            'banner_url_2' => 'required',
        ]);


        $banners = Advertisement::where('key','cartpage_banner')->first();
        $banners = json_decode(@$banners->value);
        
            
        // This condition is for the first time you want to enter banner .
        if($banners == null && !$request->hasFile("banner_image_1") && !$request->hasFile("banner_image_2")){
            toastr('You Must Enter For The First Time A Banner Images !','error','Error');
            return redirect()->back();
        }

        // dd($banners);


        for($i = 1; $i <=2; $i++){

           
            
            $oldBanner = $banners[$i-1]->{'banner_'.$i}->{'banner_image_'.$i} ?? null;

            $imageUpdatedPath = $oldBanner ;
            
            
            if($request->hasFile("banner_image_$i")){

                $imageUpdatedName = $this->updateImage_Trait($request,"banner_image_$i",AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

                $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
                
            }



                $data [] = [
                    "banner_$i"=>[
                        "banner_image_$i" => $imageUpdatedPath,
                        "banner_url_$i" => $request->{'banner_url_'.$i},
                    ]
                ] ;

        }

       
        $data [] =[
            'status'=>($request->status == 'on' ? 1 : 0)
        ];

        

        Advertisement::updateOrCreate(
            [
                'key'=>'cartpage_banner'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Cartpage Banner Updated Successfully !','success','Success');
        return redirect()->back();


    }


    public function homepageBannerFlashSaleEndDate(Request $request){

        $request->validate([
            'banner_image' =>['image'],
            'banner_url' => 'required'
        ]);

        $bannerOne = Advertisement::where('key','homepage_banner_flash_sale_end_date')->first();
        $bannerOne = json_decode(@$bannerOne->value, true);

        

        // This condition is for the first time you want to enter banner .
        if($bannerOne == null && !$request->hasFile('banner_image')){
            toastr('You Must Enter For The First Time A Banner Image !','error','Error');
            return redirect()->back();
        }

        
        $oldBanner = $bannerOne['banner_image'] ?? null;

        $imageUpdatedPath = $oldBanner ;
        
        
        if($request->hasFile('banner_image')){

            $imageUpdatedName = $this->updateImage_Trait($request,'banner_image',AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

            $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
            
        }



        $data = [
            'banner_image' => $imageUpdatedPath,
            'banner_url' => $request->banner_url,
            'status' => ($request->status == 'on' ? 1 : 0),
        ] ;

        Advertisement::updateOrCreate(
            [
                'key'=>'homepage_banner_flash_sale_end_date'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Homepage Banner Flash Sale End Date Updated Successfully !','success','Success');
        return redirect()->back();

    }


    public function flashSaleSeeMoreBanner(Request $request){

        $request->validate([
            'banner_image_1' =>['image'],
            'banner_url_1' => 'required',
            'banner_image_2' =>['image'],
            'banner_url_2' => 'required',
        ]);


        $banners = Advertisement::where('key','flash_sale_see_more_banner')->first();
        $banners = json_decode(@$banners->value);
        
            
        // This condition is for the first time you want to enter banner .
        if($banners == null && !$request->hasFile("banner_image_1") && !$request->hasFile("banner_image_2")){
            toastr('You Must Enter For The First Time A Banner Images !','error','Error');
            return redirect()->back();
        }

        // dd($banners);


        for($i = 1; $i <=2; $i++){

           
            
            $oldBanner = $banners[$i-1]->{'banner_'.$i}->{'banner_image_'.$i} ?? null;

            $imageUpdatedPath = $oldBanner ;
            
            
            if($request->hasFile("banner_image_$i")){

                $imageUpdatedName = $this->updateImage_Trait($request,"banner_image_$i",AdvertisementController::FOLDER_PATH,AdvertisementController::FOLDER_NAME,$imageUpdatedPath);

                $imageUpdatedPath = "storage/Uploads/images/banners/$imageUpdatedName" ;
                
            }



                $data [] = [
                    "banner_$i"=>[
                        "banner_image_$i" => $imageUpdatedPath,
                        "banner_url_$i" => $request->{'banner_url_'.$i},
                    ]
                ] ;

        }

       
        $data [] =[
            'status'=>($request->status == 'on' ? 1 : 0)
        ];

        

        Advertisement::updateOrCreate(
            [
                'key'=>'flash_sale_see_more_banner'
            ],
            [
                'value'=>json_encode($data)
            ]
        );


        toastr('Flash Sale See More Banner Updated Successfully !','success','Success');
        return redirect()->back();
    }













    public function changeViewList(Request $request){
        Session::put('banners_view_list',$request->style);
    }


    /** This code for changing status when you switch the checkbox with ajax  */
    // public function bannerOneChangeStatus(Request $request)
    // {
    //     // dd($request->all());
    //     $bannerOne = Advertisement::find($request->id);
        
    //     $data = json_decode(  $bannerOne->value,true);

    //     // dd($bannerOneValue);
        
    //     if(!$bannerOne){
    //         toastr()->error( 'Banner One is not found!');
    //         return to_route('admin.advertisement.index');
    //     }

        
    //     $data['status'] = $request->status == 'true' ? 1 : 0;
       
    //     $bannerOne->update(
    //         [
    //             'value'=>json_encode($data)
    //         ]
    //     );

    //     $status =($data['status'] == 1) ? 'activated' : 'deactivated';

    //     return response(['status'=>'success','message'=>"The Banner One has been $status"]);

       
    // }

}
