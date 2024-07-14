<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait imageUploadTrait{


    function uploadImage_Trait(Request $request ,$inputName, $folderPath, $folderName){

        // $Folder_name='sliders';

        $folder= $folderPath.$folderName;
        
        // store the image in storage folder (Storage/public/path..)

        $imageStore =  $request->$inputName->store($folder);

        //name of the image : 
        $imageName = basename($imageStore);
        
        return $imageName;
    }

    function deleteImage_Trait($old_image):void
    {
        if(file_exists(public_path($old_image))){
            File::delete(public_path($old_image));   
        }
    }


    function updateImage_Trait(Request $request ,$inputName, $folderPath, $folderName,$old_image){
        
        if(file_exists(public_path($old_image))){
            File::delete(public_path($old_image));   
        }

        $folder= $folderPath.$folderName;
        
        // store the image in storage folder (Storage/public/path..)

        $imageStore =  $request->$inputName->store($folder);

        //name of the image : 
        $imageName = basename($imageStore);
        
        return $imageName;
    }
    
    
    
}
