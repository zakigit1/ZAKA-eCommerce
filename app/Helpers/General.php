<?php

use App\Models\GeneralSetting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\File;


// function uploadImage($image , $folder){
//    // saving the image in owr project folder
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


// make the side bar active  when you click : [BACKEND]

function setActive(array $route){
    if(is_array($route)){
        foreach($route as $r){
            if(request()->routeIs($r)){
                return 'active';
            }
        }
    }
}

// check if is there discount or not :[FRONTEND]

function check_discount($product){
    $current_date = date('Y-m-d');
 
    if($product->offer_price > 0 && $current_date >= $product->offer_start_date && $current_date <= $product->offer_end_date ){
        return true;
    }

    return false;

}
function calculate_discount_percentage($originalPrice , $discount){

    $discount_percentage = (( $originalPrice - $discount )/ $originalPrice ) * 100 ;

    return intval($discount_percentage) ;// intval == integer value
    
}

function productType($type){
    switch ($type) {
        case 'new_arrival':
           return 'New';
            break ;
        case 'featured_product':
           return 'Featured';
            break;
        case 'top_product':
           return 'Top';
            break;
        case 'best_product':
            return'Best';
            break;
        
        default:
            return'';
            break;
    }
}

function currencyIcon(){
    return GeneralSetting::first()->currency_icon;
   
}


//get cart sidebar total : 

function getCartTotal(){
    $total = 0; 
        
    foreach(Cart::content() as $product){
        $total += ($product->price + $product->options->variants_total_amount) * $product->qty;
    }
    return $total;
}