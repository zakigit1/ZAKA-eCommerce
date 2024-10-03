<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(){

        // $wishlist_products = auth()->user()->wishlist()->get();

        $wishlists = Wishlist::with('product')->where('user_id' , Auth::user()->id)->orderBy('id','DESC')->get();

        // if(count($wishlists) == 0 ){

        //     toastr('Please add some products in your wishlist for view the wishlist page !','warning','Wishlist Is Empty !');
        //     return redirect()->route('home');
        // }

        
        return view('Frontend.store.pages.wishlist',compact('wishlists'));
    }


    public function addToWishlist(Request $request){

        // dd($request->all());

        if(!Auth::check()){
            return response(['status'=>'error','message'=>'You Must Be Login']);
        }

        $wishlist_product_count = Wishlist::where('product_id' , $request->productId)->count();

        if($wishlist_product_count > 0){
            return response(['status'=>'error','message'=>'The Product Is Already Exsist In The Wishlist']);
        }

        $wishlist = new Wishlist() ;
        
        $wishlist->user_id = Auth::user()->id ;
        $wishlist->product_id = $request->productId;
        $wishlist->save();

        $wishlist_count = Wishlist::where('user_id' , Auth::user()->id)->count();

        return response(['status'=>'success','message'=>'The Product Has Been Added To The Wishlist' ,'count' => $wishlist_count]);
    }

    public function removeProductFromWishlist(Request $request){

        // dd($request->all());

        $wishlist = Wishlist::find($request->wishlist_id);


        if(!$wishlist){
            toastr('there is something wrong try again later','error','Wishlist Error');
            return redirect()->back();
        }

        $productName = $wishlist->product->name;

        $wishlist->delete();
        
        
        toastr("The $productName Has Been Removed Successfully From The Wishlist",'success','Wishlist Success');
        return redirect()->back();
    }


    /** Clear all Product Frome The Wishlist   : */
    // public function clearWishlist(){
        
    //     $wishlists = Wishlist::where('user_id' , Auth::user()->id)->get();
        
    //     $wishlists->delete();

    //     return redirect()->back();
    // }
}
