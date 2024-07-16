<?php

use Illuminate\Support\Facades\File;


// function uploadImage($image , $folder){
//     // saving the image in owr project folder
//     $image->store('/', $folder);
    
//     //hash name of file or photo to upload so : example : hashName(zaki.jpg) --> 1055489.jpg
//     $hashphoto = $image->hashName();

//     // path of folder to transfer to Database
//     // $path = 'images/' . $folder . '/' . $hashphoto;
//     $path = $hashphoto;
//     return $path;
// }






function uploadImageNew($image , $folderPath, $folderName ){
    
    $folder= $folderPath.$folderName;

    $imageStore =  $image->store($folder);
    $imageName = basename($imageStore);
    
    return $imageName;
}

function updateImage($image, $folderPath, $folderName,$old_image){

    if(file_exists(public_path($old_image))){
        File::delete(public_path($old_image));   
    }

    $folder= $folderPath.$folderName;

    // store the image in storage folder (Storage/public/path..)

    $imageStore =  $image->store($folder);

    //name of the image : 
    $imageName = basename($imageStore);

    return $imageName;

    }

function deleteImage($old_image):void
{
    if(file_exists(public_path($old_image))){
        File::delete(public_path($old_image));   
    }
}



// make the side bar active  when you click : 

function setActive(array $route){
    if(is_array($route)){
        foreach($route as $r){
            if(request()->routeIs($r)){
                return 'active';
            }
        }
    }
}