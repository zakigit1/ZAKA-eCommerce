<?php

namespace App\Http\Controllers\Backend\Admin;

use App\DataTables\AdminProductReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use App\Traits\imageUploadTrait;
use Illuminate\Http\Request;

class AdminProductReviewController extends Controller
{

    use imageUploadTrait;

    public function index(AdminProductReviewDataTable  $dataTable){
        return $dataTable->render('admin.product.review.index');    
    }

    public function productReviewGallery(String $id){

        $productReview = ProductReview::find($id);

        // $productReviewGallery = ProductReviewGallery::where('product_review_id',$id)->get();


        return view('admin.product.review.review-gallery',compact('productReview'));

    }

    public function destroy(int $id){


        try{
            $productReview = ProductReview::find($id);

            if(!$productReview){
                toastr('Product Review Not Found','error','Error');
                return redirect()->route('admin.product-review.index');
            }
    
            if(isset($productReview->productReviewGalleries)  && count($productReview->productReviewGalleries) > 0){
    
                foreach($productReview->productReviewGalleries as $productReview_image){
                    $this->deleteImage_Trait($productReview_image->image);
                    $productReview_image->delete();
                }
                
                // $productReview->productReviewGalleries()->delete();
            }
    
            $productReview->delete();
    
            return response(['status'=>'success','message'=>"Product Review Has Been Deleted Successfully !"]);
        }catch(\Exception $ex){
            // return response(['status'=>'error','message'=>$ex->getMessage() ]);
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }


    }
    public function productReviewGalleryDestroy(int $id){
       
        try{
            $productReviewGallery = ProductReviewGallery::find($id);

            if(!$productReviewGallery){
                toastr('Product Review Gallery Not Found','error','Error');
                return redirect()->back();
            }

            $this->deleteImage_Trait($productReviewGallery->image);
            $productReviewGallery->delete();
                
                
            return response(['status'=>'success','message'=>"Product Review Image Has Been Deleted Successfully !"]);
        }catch(\Exception $ex){
            // return response(['status'=>'error','message'=>$ex->getMessage() ]);
            return response(['status'=>'error','message'=>'حدث خطا ما برجاء المحاوله لاحقا']);
        }


    }


    public function change_status(Request $request)
    {
        $productReview =ProductReview::find($request->id);

        if(!$productReview){
            toastr()->error( 'Product Review is not found!');
            return to_route('admin.product-review.index');
        }


        
        $productReview->status = $request->status == 'true' ? 1 : 0;
         
        $productReview->save();

        $status =($productReview->status == 1) ? 'activated' : 'deactivated';

        return response(['status'=>'success','message'=>"The Product Review has been $status"]);

       
    }




}



