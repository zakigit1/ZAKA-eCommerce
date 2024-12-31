<?php

use App\Models\Coupon;
use App\Models\GeneralSetting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Mtownsend\RemoveBg\RemoveBg;
use Illuminate\Support\Facades\Storage;



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



    function uploadImageWithResize($image, $folderPath, $folderName){
        try{
            
            $folder = $folderPath . $folderName;
    
            // Create temp file
            $tempPath = storage_path('app/temp/') . uniqid() . '.' . $image->getClientOriginalExtension();
            if (!is_dir(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }
    
            $image->move(dirname($tempPath), basename($tempPath));
    
            // Simple resize with GD driver
            $resizedPath = storage_path('app/temp/') . uniqid() . '.png';
            $imageManager = new ImageManager(new Driver());
            $img = $imageManager->read($tempPath);
            $img->resize(1200, 630);
            $img->save($resizedPath);
    
            // Store final image
            $imageStore = Storage::putFileAs(
                $folder,
                $resizedPath,
                uniqid() . '.png'
            );
            $imageName = basename($imageStore);
    
            if (file_exists($tempPath)) unlink($tempPath);
            if (file_exists($resizedPath)) unlink($resizedPath);
    
            return $imageName;

        } catch (\Exception $e) {
            if (isset($tempPath) && file_exists($tempPath)) unlink($tempPath);
            if (isset($resizedPath) && file_exists($resizedPath)) unlink($resizedPath);
            throw $e;
        }

        
    }





    // removing bg : 
    function uploadImageWithoutBg($image, $folderPath, $folderName)
    {
        try {
            // Validate image
            if (!$image->isValid()) {
                throw new \Exception('Invalid image file');
            }

            // Create temporary file
            $tempPath = storage_path('app/temp/') . uniqid() . '.' . $image->getClientOriginalExtension();
            if (!is_dir(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }
            $image->move(dirname($tempPath), basename($tempPath));

            // Remove background
            $removeBg = new RemoveBg(config('removebg.api_key'));
            $processedPath = storage_path('app/temp/') . uniqid() . '.png';
            $removeBg->file($tempPath)
                    ->save($processedPath);

            // Store processed image
            $folder = $folderPath . $folderName;
            $imageStore = Storage::putFileAs(
                $folder,
                $processedPath,
                uniqid() . '.png'
            );
            $imageName = basename($imageStore);

            // Cleanup temporary files
            if (file_exists($tempPath)) unlink($tempPath);
            if (file_exists($processedPath)) unlink($processedPath);

            return $imageName;

        } catch (\Exception $e) {
            // Cleanup on error
            if (isset($tempPath) && file_exists($tempPath)) unlink($tempPath);
            if (isset($processedPath) && file_exists($processedPath)) unlink($processedPath);
            
            throw $e;
        }
    }




    // removing bg & resized images : 
    function uploadImageResizeWithoutBg($image, $folderPath, $folderName)
    {
        try {
            // Validate image
            if (!$image->isValid()) {
                throw new \Exception('Invalid image file');
            }

            // Create temporary file
            $tempPath = storage_path('app/temp/') . uniqid() . '.' . $image->getClientOriginalExtension();
            if (!is_dir(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }
            $image->move(dirname($tempPath), basename($tempPath));

            // Remove background
            $removeBg = new RemoveBg(config('removebg.api_key'));
            $processedPath = storage_path('app/temp/') . uniqid() . '.png';
            $removeBg->file($tempPath)
                    ->save($processedPath);

            // Resize image using Intervention Image
            $resizedPath = storage_path('app/temp/') . uniqid() . '.png';
            $imageManger = new ImageManager(new Driver());
            $img =$imageManger->read($processedPath);


            $img->resize(1200, 630);
            // $img->resize(1280, 640);
            $img->save($resizedPath);
            
            // Store processed image
            $folder = $folderPath . $folderName;
            $imageStore = Storage::putFileAs(
                $folder,
                $resizedPath,
                uniqid() . '.png'
            );
            $imageName = basename($imageStore);

            // Cleanup temporary files
            if (file_exists($tempPath)) unlink($tempPath);
            if (file_exists($processedPath)) unlink($processedPath);
            if (file_exists($resizedPath)) unlink($resizedPath);

            return $imageName;

        } catch (\Exception $e) {
            // Cleanup on error
            if (isset($tempPath) && file_exists($tempPath)) unlink($tempPath);
            if (isset($processedPath) && file_exists($processedPath)) unlink($processedPath);
            if (isset($resizedPath) && file_exists($resizedPath)) unlink($resizedPath);
            
            throw $e;
        }
    }


    // function uploadImageResizeWithoutBg2($image, $folderPath, $folderName, $removeBg = false, $resize = false) 
    // {
    //     try {
    //         // Validate image
    //         if (!$image->isValid()) {
    //             throw new \Exception('Invalid image file');
    //         }

            
    //         /** -Start-  Remove bg process : */
    //             $RemoveBgImage = RemoveBgImage($image);

    //             $imageManager = $RemoveBgImage[0];
    //             $processedPath = $RemoveBgImage[1];
    //             $tempPath = $RemoveBgImage[2];

    //         /** -End-  Remove bg process : */
    
    //         /** -Start-  Resize image using Intervention Image v3 : */
    //             $resizedPath = resize($imageManager,$processedPath);
    //         /** -End- Resize image using Intervention Image v3 : */
    

    //         /** -Start- Store processed image : */
    //             $imageName = storeFinalImageAfterModification($folderPath, $folderName, $resizedPath);
    //         /** -End- Store processed image : */

    
    //         /** -Start- Cleanup temporary files : */
    //             cleanupTemporaryFiles($tempPath,$processedPath,$resizedPath);
    //         /** -End- Cleanup temporary files : */

    //         return $imageName;
    
    //     } catch (\Exception $e) {
    //         // Cleanup on error

    //         cleanupTemporaryFiles($tempPath,$processedPath,$resizedPath,true);
    //         throw $e;
    //     }
    // }


    
    
    function uploadImageResizeWithoutBg2($image, $folderPath, $folderName,bool $removeBg = false,bool $resize = false) 
    {
        try {
            // Validate image
            if (!$image->isValid()) {
                throw new \Exception('Invalid image file');
            }

            $imageName = '';

            if($removeBg == true &&  $resize == true){
                /** -Start-  Remove bg process : */
                    $RemoveBgImage = RemoveBgImage($image);
    
                    $imageManager = $RemoveBgImage[0];
                    $processedPath = $RemoveBgImage[1];
                    $tempPath = $RemoveBgImage[2];
    
                /** -End-  Remove bg process : */
        
                /** -Start-  Resize image using Intervention Image v3 : */
                    $resizedPath = resize($imageManager,$processedPath);
                /** -End- Resize image using Intervention Image v3 : */
        
    
                /** -Start- Store processed image : */
                    $imageName = storeFinalImageAfterModification($folderPath, $folderName, $resizedPath);
                /** -End- Store processed image : */
    
        
                /** -Start- Cleanup temporary files : */
                    cleanupTemporaryFiles($tempPath,$processedPath,$resizedPath);
                /** -End- Cleanup temporary files : */
            }elseif($removeBg == true && $resize == false){
                /** -Start-  Remove bg process : */
                    $RemoveBgImage = RemoveBgImage($image);
                    $processedPath = $RemoveBgImage[1];
                /** -End-  Remove bg process : */

                /** -Start- Store processed image : */
                $imageName = storeFinalImageAfterModification($folderPath, $folderName, false,$processedPath);
                /** -End- Store processed image : */

            }elseif($removeBg == false && $resize == true){

                // Create temp file
                $tempPath = storage_path('app/temp/') . uniqid() . '.' . $image->getClientOriginalExtension();
                if (!is_dir(dirname($tempPath))) {
                    mkdir(dirname($tempPath), 0755, true);
                }
                $image->move(dirname($tempPath), basename($tempPath));
        
                // Simple resize with GD driver
                $resizedPath = storage_path('app/temp/') . uniqid() . '.png';
                $imageManager = new ImageManager(new Driver());
                $img = $imageManager->read($tempPath);
                $img->resize(1200, 630);
                $img->save($resizedPath);
        
                
                /** -Start- Store processed image : */
                $imageName = storeFinalImageAfterModification($folderPath, $folderName, $resizedPath);
                /** -End- Store processed image : */

            }else{
                $imageName = uploadImageNew($image , $folderPath, $folderName);
            }

    
            return $imageName;
    
        } catch (\Exception $e) {
            // Cleanup on error

            cleanupTemporaryFiles($tempPath,$processedPath,$resizedPath,true);
            
            throw $e;
        }
    }


    /** ++Start++ all this function is used in uploadImageResizeWithoutBg2 function  */
        function RemoveBgImage($image)
        {
            // Create temporary file
            $tempPath = storage_path('app/temp/') . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!is_dir(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }

            $image->move(dirname($tempPath), basename($tempPath));

            // Check if image already has transparency
            $imageManager = new ImageManager(new Driver());
            $img = $imageManager->read($tempPath);
            
            // Get image info using core methods
            $hasTransparency = $image->getClientMimeType() === 'image/png' && 
                                imagecolortransparent(imagecreatefrompng($tempPath)) !== -1;

            if ($hasTransparency) {
                $processedPath = $tempPath; // Skip background removal
            } else {
                // Remove background only if image is not transparent
                $removeBg = new RemoveBg(config('removebg.api_key'));
                $processedPath = storage_path('app/temp/') . uniqid() . '.png';
                $removeBg->file($tempPath)
                        ->save($processedPath);
            }

            return [
                $imageManager,
                $processedPath,
                $tempPath
            ];
        }


        function resize($imageManager,$processedPath)
        {
            $resizedPath = storage_path('app/temp/') . uniqid() . '.png';
            $imgToResize = $imageManager->read($processedPath);
            $imgToResize->resize(1200, 630); // Using your specified dimensions
            // $imgToResize->resize(1280, 640); // Using your specified dimensions

            // Set image specifications ( you need to install : imagick library)
            // $imgToResize->modify(function($image) {
            //     $image->getCore()->setImageUnits(Imagick::RESOLUTION_PIXELSPERINCH);
            //     $image->getCore()->setImageResolution(72, 72);
            //     $image->getCore()->setImageDepth(24);
            //     $image->getCore()->setImageColorspace(Imagick::COLORSPACE_UNDEFINED); // Uncalibrated
            //     $image->getCore()->setImageProperty('resolution-unit', '2'); // 2 = inches
            // });
            $imgToResize->save($resizedPath);

            return $resizedPath;
        }

        function storeFinalImageAfterModification($folderPath, $folderName, $resizedPath=false, $processedPath=false)
        {
            $folder = $folderPath . $folderName;

            $imageName = '';
            $imageStore = '';

            if($resizedPath !== false && $processedPath !== false){ // if we do removing bg and resizing 

                $imageStore = Storage::putFileAs(
                    $folder,
                    $resizedPath, 
                    uniqid() . '.png'
                );

                // $imageName = basename($imageStore);
                // return $imageName;
            }elseif($processedPath !== false && $resizedPath === false){ // if we do just  removing bg

                $imageStore = Storage::putFileAs(
                    $folder,
                    $processedPath,
                    uniqid() . '.png'
                );

                // $imageName = basename($imageStore);
                // return $imageName;
            }elseif( $resizedPath !== false && $processedPath === false){ // if we do just resizing 
                $imageStore = Storage::putFileAs(
                    $folder,
                    $resizedPath,
                    uniqid() . '.png'
                );
                // $imageName = basename($imageStore);
                // return $imageName;
            }
            
            
            $imageName = basename($imageStore);
            return $imageName;
        }

        function cleanupTemporaryFiles($tempPath,$processedPath,$resizedPath,$exception = false)
        {   
            if ($exception === true) {
                if (isset($tempPath) && file_exists($tempPath)) unlink($tempPath);
                if (isset($processedPath) && file_exists($processedPath)) unlink($processedPath);
                if (isset($resizedPath) && file_exists($resizedPath)) unlink($resizedPath);
            }else{

                if (file_exists($tempPath)) unlink($tempPath);
                if (file_exists($processedPath)) unlink($processedPath);
                if (file_exists($resizedPath)) unlink($resizedPath);
            }
        }

    /** ++End++ all this function is used in uploadImageResizeWithoutBg2 function  */



    function updateImageResizeWithoutBg($image, $folderPath, $folderName, $old_image, bool $removeBg = false, bool $resize = false)
    {

        if(file_exists(public_path($old_image))){
            File::delete(public_path($old_image));   
        }

        $imageName = uploadImageResizeWithoutBg2($image, $folderPath, $folderName,$removeBg,$resize);
        return $imageName;
    }





    function uploadImageNew($image , $folderPath, $folderName ){
        
        $folder= $folderPath.$folderName;

        $imageStore =  $image->store($folder);
        $imageName = basename($imageStore);
        
        return $imageName;
    }

    function updateImage($image, $folderPath, $folderName,$old_image)
    {

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


/** Get cart sidebar total : [Frontend] */ 
    function getCartSubtotal(){
        $total = 0; 
            
        foreach(Cart::content() as $product){
            $total += ($product->price + $product->options->variants_total_amount) * $product->qty;
        }
        return $total;
    }


/** Get cart total : [Frontend] ** is the sub total - discount(coupon) ** */  
    function cartTotal(){

        if(Session::has('coupon')){
            $couponSession = Session::get('coupon');// i can use directely couponsession 
            $coupon = Coupon::where('name',$couponSession['coupon_name'])->first();

            $subTotal = getCartSubtotal(); // this function you found it in the general file

            if($coupon->discount_type == 'amount'){

                $discount = $coupon->discount;
                $total = $subTotal - $discount;

                return $total;

            }elseif($coupon->discount_type == 'percent'){

                $discount =  (($subTotal * $coupon->discount) / 100);
                $total = $subTotal - $discount;

                return $total;
            }
        }else{
            return getCartSubtotal();
        }
    }


/** Get cart discount : [Frontend] */ 

    function cartDiscount(){
        
        if(Session::has('coupon')){
            $couponSession = Session::get('coupon');// i can use directely couponsession 
            $coupon = Coupon::where('name',$couponSession['coupon_name'])->first();

                $subTotal = getCartSubtotal(); // this function you found it in the general file

                if($coupon->discount_type == 'amount'){

                    $discount = $coupon->discount;
                    return $discount;

                }elseif($coupon->discount_type == 'percent'){
                    $discount = (($subTotal * $coupon->discount) / 100);
                    return $discount;
                }
            }else{
                return 0.00;
            }
        }
/** Get shipping fee : [Frontend] */ 

    function shippingFee(){
        if(Session::has('shipping_method')){
            $shippingFee = Session::get('shipping_method')['cost'];
            return $shippingFee;
        }else{
            return 0.00 ;
        }
    }

/** Get total price after adding shipping Fee : [Frontend] */ 

    function finalAmount(){
        return cartTotal() + shippingFee() ;
    }


/** Text limitaion :  [FrontEnd]*/

    function limitText($text , $limit =20){
        return Str::limit($text ,$limit);
    }

