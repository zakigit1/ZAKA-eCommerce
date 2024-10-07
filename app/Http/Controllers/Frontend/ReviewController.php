<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserProductReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReviewController extends Controller
{
    use imageUploadTrait;
    const FOLDER_PATH = '/Uploads/images/products/';
    const FOLDER_NAME = 'review';

    public function index(UserProductReviewDataTable  $dataTable){
        return $dataTable->render('Frontend.user.Dashboard.review.index');    
    }
    public function create(Request $request){


        $request->validate([
            'vendor_id' => 'required',
            'product_id' => 'required',
            'rating' => 'required|integer',//integer check ?
            'review' => ['nullable','string','max:200'],
            'images.*' => 'image',
        ]);

        // dd($request->all());
        try{

            $checkUserReviewExist = ProductReview::where('product_id',$request->product_id)
            ->where('user_id', Auth::user()->id)
            ->first();


            if($checkUserReviewExist){
                if($checkUserReviewExist->status == 1){
                    toastr('You Already Added A Review For This Product !','error','Error');
                    return redirect()->back();
                }else{
                    toastr('You Already Added A Review For This Product And The Admin Need To Check Your Review !','error','Error');
                    return redirect()->back();
                }

            }

            $imagesNames = '';
            
            if($request->hasFile('images')){
                $imagesNames = $this->upload_Multi_Image_Trait($request,'images',self::FOLDER_PATH,self::FOLDER_NAME);
            }
            
            
            
            DB::beginTransaction();

            $productReview = ProductReview::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
                'vendor_id' => $request->vendor_id,
                'rating' => $request->rating,
                'review' => $request->review,
                'status' => 0 // must be the admin check and valide this review .
            ]);

            
            if(count($imagesNames) > 0){
                if($productReview){
                    
                    $data = []; 
                
                    foreach ($imagesNames as $imageName) {
                        $data[] = [
                            'image' => $imageName,
                            'product_review_id' => $productReview->id
                        ];
                    }
                    
                    $storeImages = ProductReviewGallery::insert($data);
                }else{ 
                    // Must delete the previous images
                    foreach ($imagesNames as $imageName) {

                        if(file_exists(public_path($imageName))){
                            File::delete(public_path($imageName));   
                        }
                    }

                    toastr('Product Review has been failed!','error','Error');
                    return redirect()->back();
                }   
        
            }
            
            DB::commit();
            toastr('Product Review has been added successfully!','success','Success');
            return redirect()->back();

        }catch(\Exception $ex){
            DB::rollBack();
            // toastr($ex->getMessage(),'error');
            toastr('Product Review has been failed!','error','Error');
            return redirect()->back();
        }


    }
}
