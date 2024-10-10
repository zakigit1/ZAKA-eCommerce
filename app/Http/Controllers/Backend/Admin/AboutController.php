<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        
        $about = About::first();
        return view('admin.about.index',compact('about'));
    }
    public function updateAbout(Request $request){

        $request->validate([
            'about_content'=>'required'
        ]);


        $update = About::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->about_content,
            ]
        );

        toastr('About Content Has Been Updated Successfully!','success', 'Success');

        return redirect()->back();
    }
}
