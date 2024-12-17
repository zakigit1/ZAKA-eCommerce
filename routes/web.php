<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\TrackOrderController;
use App\Http\Controllers\Frontend\User\UserAddressController;
use App\Http\Controllers\Frontend\User\UserDashboard;
use App\Http\Controllers\Frontend\User\UserMessageController;
use App\Http\Controllers\Frontend\User\UserOrderController;
use App\Http\Controllers\Frontend\User\UserProfileController;
use App\Http\Controllers\Frontend\User\UserVendorRequestController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

#####################################################################################

#################### Frontend store : 

// Main Page Of Store : 
Route::get('/', [HomeController::class,'index'])->name('home');

Route::group(['middleware' =>['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function(){
    
    Route::get('/dashboard', [UserDashboard::class , 'index'])->name('dashboard');
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // ?   User Dashboard Profile :  
    Route::group(['prefix'=>'profile','as'=>'profile.'],function(){

        Route::get('/', [UserProfileController::class,'index'])->name('index');
        Route::post('/update', [UserProfileController::class,'update_profile'])->name('update');
        Route::post('/update/password', [UserProfileController::class,'update_profile_password'])->name('update.password');
    });

    // ?   User Dashboard Address :  
    Route::resource('address',UserAddressController::class);

    //? User Checkout : 
    Route::group(['prefix'=>'checkout'],function(){
        
        Route::get('/',[CheckoutController::class,'index'])->name('checkout');
        Route::post('/address',[CheckoutController::class,'createAddress'])->name('checkout.add-address');
        Route::post('/submit',[CheckoutController::class,'checkoutSubmit'])->name('checkout.submit');
        
    });
    
    //? User Payment : 
    Route::group(['prefix'=>'payment'],function(){
        Route::get('/',[PaymentController::class,'index'])->name('payment');
        Route::get('/success',[PaymentController::class,'paymentSuccess'])->name('payment.success');

        /** Paypal Payment :  */
        Route::get('paypal',[PaymentController::class,'paypalPayment'])->name('paypal.payment');
        Route::get('paypal/success',[PaymentController::class,'success'])->name('paypal.success');
        Route::get('paypal/cancel',[PaymentController::class,'cancel'])->name('paypal.cancel');
        
        /** Stripe Payment :  */
        Route::post('stripe',[PaymentController::class,'stripePayment'])->name('stripe.payment');


        /** Razorpay Payment :  */
        Route::get('razorpay',[PaymentController::class,'razorpayPayment'])->name('razorpay.payment');


        /** COD Payment :  */
        Route::get('cod',[PaymentController::class,'codPayment'])->name('cod.payment');
    
    });


    ##############################  Vendor Orders Start  ###################################

    Route::get('/order/trashed-orders/',[UserOrderController::class,'trashed_orders'])->name('order.trashed-orders');
    Route::get('/order/trashed-orders/{id}/restore',[UserOrderController::class,'trashed_orders_restore'])->name('order.trashed-orders.restore');
    Route::get('/order/trashed-orders/{id}/force-delete',[UserOrderController::class,'trashed_orders_delete'])->name('order.trashed-orders.delete');
    
    Route::resource('order',UserOrderController::class)->except(['store','edit','update']);

    ##############################  Vendor Orders End  ###################################
    
    ##############################  Wishlist Start  ###################################
    
    Route::group(['prefix'=>'wishlist' , 'as'=>'wishlist.'],function(){
        route::get('/',[WishlistController::class,'index'])->name('index');
        route::get('/store',[WishlistController::class,'addToWishlist'])->name('store');
        route::get('/destroy',[WishlistController::class,'removeProductFromWishlist'])->name('destroy');
    });

    ##############################  Wishlist End  ###################################


    ##############################  Review Start  ###################################
    Route::group(['prefix'=>'product-review' , 'as'=>'product-review.'],function(){
    
        route::get('/',[ReviewController::class,'index'])->name('index');
        route::post('/create',[ReviewController::class,'create'])->name('create');

    });


    ##############################  Review End  ###################################


    ##############################  User Ask To Be A Vendor Start  #################################

    Route::get('vendor-request',[UserVendorRequestController::class ,'index'])->name('vendor-request.index');
    Route::post('vendor-request/',[UserVendorRequestController::class ,'store'])->name('vendor-request.store');



    ##############################  User Ask To Be A Vendor End  ###################################



    ##############################  Track Order Start  ###################################

    Route::get('track-order',[TrackOrderController::class,'index'])->name('track-order.index');
    ##############################  Track Order End  ###################################
    
    ##############################  Comment To Blog Start  ###################################

    Route::post('blog-comment',[BlogController::class,'blogComment'])->name('blog-comment');
    ##############################  Comment To Blog End  ###################################



    ##############################  Messanger Start  ###################################

    route::get('/messanger',[UserMessageController::class,'index'])->name('messager.index');

    /** Send message from store */
    Route::post('send-message-to-vendor',[UserMessageController::class,'clientMessage'])->name('send-message-to-vendor');

    /** Get conversion */
    Route::get('get-conversions',[UserMessageController::class,'getConversion'])->name('get-conversions');

    ##############################  Messanger End  ###################################






});



    // ?   FlashSale :  
    Route::get('/flash-sale',[FlashSaleController::class,'index'])->name('flash-sale.index');

    // ?  Product Details
    Route::get('products',[FrontendProductController::class , 'productsIndex'])->name('products.index');
    Route::get('product-details/{slug}',[FrontendProductController::class , 'showProduct'])->name('product-details');
    Route::get('change-product-view-list',[FrontendProductController::class , 'changeViewList'])->name('change-product-view-list');

    

    //? Show Product Model (eye pop up)
    Route::get('show-product-model/{id}',[HomeController::class,'showProductModel'])->name('show-product-model');

    

    /**    Cart  Routes : */  
    Route::group(['prefix'=>'cart'],function(){

        Route::get('details',[CartController::class , 'cartDetails'])->name('cart');
        Route::post('add-to-cart',[CartController::class , 'addToCart'])->name('add-to-cart');
        Route::post('update-qty',[CartController::class , 'quantityUpdate'])->name('cart-qty-update');
        
        Route::get('destroy/{rowId}',[CartController::class , 'removeProduct'])->name('remove-product-form-cart');
        Route::get('clear',[CartController::class , 'clearCart'])->name('clear-cart');
        Route::get('counter',[CartController::class , 'getCartCount'])->name('cart-counter');
        Route::get('get-products',[CartController::class , 'getCartProducts'])->name('cart-get-products');
        
        Route::post('sidebar/destroy',[CartController::class , 'removeSidebarProduct'])->name('remove-product-form-sidebar-cart');
        
        Route::get('sidebar-product/total',[CartController::class , 'cartTotalSidebar'])->name('cart-get-total-products-sidebar');
    
        Route::get('apply-coupon',[CartController::class , 'apply_coupon'])->name('apply-coupon');
        Route::get('calculate-coupon-discount',[CartController::class , 'couponCalculation'])->name('calculate-coupon-discount');
    });




    //News Letter footer : 

    Route::post('newletter-request',[NewsletterController::class ,'newLetterRequest'])->name('newsletter-request');
    Route::get('newletter-verify/{token}',[NewsletterController::class ,'newLetterEmailVerify'])->name('newsletter-verify');



    //Show Vendors At Frontend : 

    Route::get('/vendors',[HomeController::class,'vednorIndex'])->name('vendor.index');
    Route::get('vendor/{id}/products',[HomeController::class,'vendorProducts'])->name('vendor.products');



    // About Page :
    Route::get('/about',[PageController::class,'aboutIndex'])->name('about.index');

    // Terms and conditions Page :
    Route::get('/terms-and-conditions',[PageController::class,'termsAndConditionsIndex'])->name('terms-and-conditions.index');
    


    //Contact Page :
    Route::get('/contact',[PageController::class,'index'])->name('contact.index');
    Route::post('/contact',[PageController::class,'handleContactForm'])->name('handle-contact-form');


    //Blog detail page :
    Route::get('blog-details/{slug}',[BlogController::class,'blogDetails'])->name('blog-details');
    Route::get('blog',[BlogController::class,'blogIndex'])->name('blog');
    
    // View list of mobile menu 
    Route::get('list-view',[HomeController::class , 'changeViewList'])->name('mobile-menu.view-list');




// Route::get('/register2',function(){
//     return view('Frontend.auth.register');
// })->name('front.register');




// 404 Page : 
Route::fallback(function(){

    return redirect('/');

    /**id bghit ghlat fl route whowa machi auth ydih ll home ida kan auth ydih dashboard 3la hsab role ta3ah */
    // if(!auth()->check()){
    //     return redirect('/');
    // }
    // return redirect(auth()->user()->role.'/dashboard');

    /**404 page custumizable */
    // return view('Backend.404NotFound');// i need to add page 404  general for my website 
});







// 404 Page : 
Route::get('404',function(){
    return view('Backend.404NotFound');
})->name('404');