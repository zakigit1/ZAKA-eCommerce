<?php

namespace App\Http\Controllers\Backend\Admin\Footer;

use App\Http\Controllers\Controller;
use App\Models\FooterInfo;
use Illuminate\Http\Request;
use App\Traits\imageUploadTrait;

class FooterInfoController extends Controller
{  
    use imageUploadTrait;

    const FOLDER_PATH = '/Uploads/images/';
    const FOLDER_NAME = 'footer';


    public function index () {

        $footerInfo = FooterInfo::first();

        
        return view('admin.footer.footer-info',compact('footerInfo'));
    }

    public function update (Request $request , int $id = 1) {

        $request->validate([
            'logo' => ['nullable','image','max:3000'],
            'phone' => 'max:100',
            'email' => 'max:100',
            'address' => 'max:100',
            'copyright' => 'max:100',
        ]);


        // dd($request->all());

        $footerInfo = FooterInfo::find($id);

        
        $updateImage = '';

        if($request->hasFile('logo')){

            $old_logo = $footerInfo?->logo;
            $updateImage = $this->updateImage_Trait($request,'logo',FooterInfoController::FOLDER_PATH,FooterInfoController::FOLDER_NAME,$old_logo);
        }


        // dd($updateImage);

        FooterInfo::updateOrCreate(
            ['id' => $id] ,
            [

                'logo' => $updateImage,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'copyright' => $request->copyright,
            ]
        );

        toastr()->success('Footer Information Updated Successfully !');
        return redirect()->back();
    }

}
