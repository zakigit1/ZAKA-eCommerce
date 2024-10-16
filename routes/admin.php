<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Admin\AboutController;
use App\Http\Controllers\Backend\Admin\CustomerListController;
use App\Http\Controllers\Backend\Admin\Payment\Gateways\PaypalSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\AdminListController;
use App\Http\Controllers\Backend\Admin\AdminProductReviewController;
use App\Http\Controllers\Backend\Admin\AdminVendroProfileController;
use App\Http\Controllers\Backend\Admin\AdvertisementController;
use App\Http\Controllers\Backend\Admin\Blog\BlogCommentController;
use App\Http\Controllers\Backend\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Backend\Admin\Blog\BlogController;
use App\Http\Controllers\Backend\Admin\BrandController;
use App\Http\Controllers\Backend\Admin\SliderController;
use App\Http\Controllers\Backend\Admin\CategoryController;
use App\Http\Controllers\Backend\Admin\ChildcategoryController;
use App\Http\Controllers\Backend\Admin\FlashSaleController;
use App\Http\Controllers\Backend\Admin\Product\ProductController;
use App\Http\Controllers\Backend\Admin\Product\ProductImageGalleryController;
use App\Http\Controllers\Backend\Admin\Product\ProductVariantController;
use App\Http\Controllers\Backend\Admin\SubcategoryController;
use App\Http\Controllers\Backend\Admin\Product\ProductVariantItemController;
use App\Http\Controllers\Backend\Admin\Product\SellerProductController;
use App\Http\Controllers\Backend\Admin\SettingController;
use App\Http\Controllers\Backend\Admin\CouponController;
use App\Http\Controllers\Backend\Admin\Footer\FooterGridThreeController;
use App\Http\Controllers\Backend\Admin\Footer\FooterGridTwoController;
use App\Http\Controllers\Backend\Admin\Footer\FooterInfoController;
use App\Http\Controllers\Backend\Admin\Footer\FooterSocialController;
use App\Http\Controllers\Backend\Admin\HomePageSettingController;
use App\Http\Controllers\Backend\Admin\ManageUserController;
use App\Http\Controllers\Backend\Admin\OrderController;
use App\Http\Controllers\Backend\Admin\Payment\PaymentSettingController;
use App\Http\Controllers\Backend\Admin\Payment\Gateways\RazorpaySettingController;
use App\Http\Controllers\Backend\Admin\Payment\Gateways\StripeSettingController;
use App\Http\Controllers\Backend\Admin\ShippingRuleController;
use App\Http\Controllers\Backend\Admin\SubscriberController;
use App\Http\Controllers\Backend\Admin\TermAndConditionController;
use App\Http\Controllers\Backend\Admin\TransactionController;
use App\Http\Controllers\Backend\Admin\VendorConditionController;
use App\Http\Controllers\Backend\Admin\VendorListController;
use App\Http\Controllers\Backend\Admin\VendorRequestController;




                /** The Prefix admin is in App\Providers\RouteServiceProvider */


                

Route::get('login',[AdminController::class,'login'])->name('login.page');
// Route::post('login',[AdminController::class,'loginCheck'])->name('login.check');


Route::group(['middleware'=>['auth:web','role:admin'],],function(){

        Route::get('dashboard',[AdminController::class,'index'])->name('dashboard');
        Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('profile/update', [AdminController::class, 'update_profile'])->name('profile.update');
        Route::post('profile/update/password', [AdminController::class, 'update_profile_password'])->name('profile.update.password');



    ##############################  SLIDER START  ###################################
        Route::resource('slider',SliderController::class);
    ##############################  SLIDER END  ###################################

    ##############################  Category START  ###################################
    
        // Route::POST('/category/change-status/{id}',[CategoryController::class,'change_status'])->name('category.change-status');
        Route::put('/category/change-status/',[CategoryController::class,'change_status'])->name('category.change-status');
        Route::resource('category',CategoryController::class);
    ##############################  Category END  ###################################
    

    ##############################  Sub-Category START  ###################################
        // Route::POST('/sub-category/change-status/{id}',[CategoryController::class,'change_status'])->name('category.change-status');
        Route::put('/sub-category/change-status/',[SubcategoryController::class,'change_status'])->name('sub-category.change-status');
        Route::resource('sub-category',SubcategoryController::class);
    ##############################  Sub-Category END  ###################################

    ##############################  Child-category START  ###################################
        // Route::POST('/sub-category/change-status/{id}',[CategoryController::class,'change_status'])->name('category.change-status');
        Route::get('child-category/get-sub-categories/',[ChildcategoryController::class,'get_subcategories'])->name('child-category.get-sub-categories');
        Route::put('/child-category/change-status/',[ChildcategoryController::class,'change_status'])->name('child-category.change-status');
        Route::resource('child-category',ChildcategoryController::class);
    ##############################  Child-category END  ###################################

    ##############################  Brand START  ###################################

        Route::group(['prefix'=>'brand'],function(){
            
            Route::get('/',[BrandController::class,'index'])->name('brand.index');
            Route::get('create',[BrandController::class,'create'])->name('brand.create');
            Route::post('store',[BrandController::class,'store'])->name('brand.store');
            Route::get('/{id}/edit',[BrandController::class,'edit'])->name('brand.edit');
            Route::post('{id}/update',[BrandController::class,'update'])->name('brand.update');
            Route::DELETE('{id}/destroy',[BrandController::class,'destroy'])->name('brand.destroy');
            Route::put('change-status',[BrandController::class,'change_status'])->name('brand.change-status');

        });

    ############################## Admin  Vendor Profile Start  ###################################

        Route::group(['prefix'=>'vendor-profile','as'=>'vendor-profile.'],function(){
            
            Route::get('/',[AdminVendroProfileController::class,'index'])->name('index');
            Route::post('/update',[AdminVendroProfileController::class,'update_admin_vendor_profile'])->name('update');


        });

    ############################## Admin Vendor Profile End  ###################################

    ##############################  Product Start  ###################################

        Route::group(['prefix'=>'product','as'=>'product.'],function(){
            Route::get('/',[ProductController::class,'index'])->name('index');
            Route::get('create',[ProductController::class,'create'])->name('create');
            Route::post('store',[ProductController::class,'store'])->name('store');
            Route::get('/{id}/edit',[ProductController::class,'edit'])->name('edit');
            Route::post('{id}/update',[ProductController::class,'update'])->name('update');
            Route::DELETE('{id}/destroy',[ProductController::class,'destroy'])->name('destroy');
            Route::put('change-status',[ProductController::class,'change_status'])->name('change-status');
            Route::get('get-sub-categories',[ProductController::class,'get_subcategories'])->name('get-sub-categories');
            Route::get('get-child-categories',[ProductController::class,'get_childcategories'])->name('get-child-categories');
        });


        Route::group(['prefix'=>'product-image-gallery','as'=>'product-image-gallery.'],function(){
            Route::get('/',[ProductImageGalleryController::class,'index'])->name('index');

            Route::post('store',[ProductImageGalleryController::class,'store'])->name('store');
            Route::get('/{id}/edit',[ProductImageGalleryController::class,'edit'])->name('edit');
            Route::post('{id}/update',[ProductImageGalleryController::class,'update'])->name('update');
            Route::DELETE('{id}/destroy',[ProductImageGalleryController::class,'destroy'])->name('destroy');
            Route::DELETE('{id}/destroyAll',[ProductImageGalleryController::class,'destroyAllImages'])->name('destroy-all-images');
            
        });

        Route::group(['prefix'=>'product-variant','as'=>'product-variant.'],function(){
            Route::get('/',[ProductVariantController::class,'index'])->name('index');
            Route::get('create',[ProductVariantController::class,'create'])->name('create');
            Route::post('store',[ProductVariantController::class,'store'])->name('store');
            Route::get('/{id}/edit',[ProductVariantController::class,'edit'])->name('edit');
            Route::post('{id}/update',[ProductVariantController::class,'update'])->name('update');
            Route::DELETE('{id}/destroy',[ProductVariantController::class,'destroy'])->name('destroy');
            Route::put('change-status',[ProductVariantController::class,'change_status'])->name('change-status');
            
        });
        Route::group(['prefix'=>'product-variant-item','as'=>'product-variant-item.'],function(){

            Route::get('/{productId}/{variantId}',[ProductVariantItemController::class,'index'])->name('index');
            Route::get('create/{productId}/{variantId}',[ProductVariantItemController::class,'create'])->name('create');
            Route::post('store',[ProductVariantItemController::class,'store'])->name('store');
            Route::get('/{itemId}/edit/edit',[ProductVariantItemController::class,'edit'])->name('edit');
            Route::post('{itemId}/update',[ProductVariantItemController::class,'update'])->name('update');
            Route::DELETE('{itemId}/destroy',[ProductVariantItemController::class,'destroy'])->name('destroy');
            Route::put('change-status',[ProductVariantItemController::class,'change_status'])->name('change-status');
            
        });

    ##############################  Product End  ###################################

    ##############################  Seller or Vendor Product Start  ###################################

        
        Route::get('/seller-product',[SellerProductController::class,'index'])->name('seller-product.index');
        
        Route::get('/seller-pending-product',[SellerProductController::class,'pending_products'])->name('seller-pending-product.index');

        Route::post('/product-change-approve-status',[SellerProductController::class,'change_approve_status'])->name('product-change-approve-status');


    ############################## Seller or vendor Product End  ###################################


    ############################## Flash Sale  Start  ###################################

        Route::group(['prefix'=>'flash-sale','as'=>'flash-sale.'],function(){
            Route::get('/',[FlashSaleController::class,'index'])->name('index');
            Route::post('/end-date',[FlashSaleController::class,'end_date'])->name('end_date');
            Route::post('/add-product',[FlashSaleController::class,'add_product'])->name('add_product');  
            Route::DELETE('{id}/destroy',[FlashSaleController::class,'destroy'])->name('destroy');
            Route::put('change-status',[FlashSaleController::class,'change_status'])->name('change-status');
            Route::put('change-at-home-status',[FlashSaleController::class,'change_at_home_status'])->name('change-at-home-status');
            
        });
    ############################## Flash Sale  End  ###################################
    
    ############################## Settings  Start  ###################################
    
        Route::group(['prefix'=>'settings','as'=>'settings.'],function(){
            
            Route::get('',[SettingController::class , 'index'])->name('index');

            /** Update Or Create general Settings :( if general settings is not created yet we created else we update general settings)  */
            Route::put('/general-settings/update',[SettingController::class , 'UpdateSettingsGeneral'])->name('general-settings.update');
            
            /** Update Or Create Email configuration Settings :( if general settings is not created yet we created else we update email configuration settings)  */
            Route::put('/email-settings/update',[SettingController::class , 'UpdateEmailConfiguration'])->name('email-settings.update');


            Route::get('list-view',[SettingController::class , 'changeViewList'])->name('view-list');
        });
    
    ############################## Settings  End  ###################################


    ############################## Coupons  Start  ###################################

        Route::put('/coupons/change-status/',[CouponController::class,'change_status'])->name('coupons.change-status');
        Route::resource('coupons',CouponController::class);

    ############################## Coupons  End  ###################################


    ############################## Shipping Rule  Start  ###################################

        Route::put('/shipping-rules/change-status/',[ShippingRuleController::class,'change_status'])->name('shipping-rule.change-status');
        Route::resource('shipping-rules',ShippingRuleController::class);

    ############################## Shipping Rule  End  ###################################
    
    
    ############################## Payment  Start  #################################
    
    
    
    Route::group(['prefix'=>'payment','as'=>'payment.'],function(){
        
        Route::get('/',[PaymentSettingController::class,'index'])->name('index');

        
        ############################## Paypal Settings gateway  Start  #################################
        
        /** Update Or Create Paypal Settings :( if Paypal settings is not created yet we created else we update paypal settings)  */
        Route::put('/paypal-settings',[PaypalSettingController::class,'UpdatePaypalSettings'])->name('paypal-setting');
        
        ############################## Paypal Settings gateway  End  #################################
        
        ############################## Stripe Settings gateway  Start  #################################
        
        /** Update Or Create Stripe Settings :( if Stripe settings is not created yet we created else we update stripe settings)  */
        Route::put('/stripe-settings',[StripeSettingController::class,'UpdateStripeSettings'])->name('stripe-setting');
        ############################## Stripe Settings gateway  End  #################################

        ############################## Razorpay Settings gateway  Start  #################################
        
        /** Update Or Create Razorpay Settings :( if Razorpay settings is not created yet we created else we update razorpay settings)  */
        Route::put('/razorpay-settings',[RazorpaySettingController::class,'UpdateRazorpaySettings'])->name('razorpay-setting');
        ############################## Razorpay Settings gateway  End  #################################
    });

    ############################## Payment  End  ###################################
    
    ############################## Order  Start  ###################################

        ############################## Order Status  Start  #################################
            Route::get('/order/pending/',[OrderController::class,'pendingOrders'])->name('order.pending');
            Route::get('/order/processing/',[OrderController::class,'processedOrders'])->name('order.processing');
            Route::get('/order/dropped-off/',[OrderController::class,'dropped_offOrders'])->name('order.dropped-off');
            Route::get('/order/shipped/',[OrderController::class,'shippedOrders'])->name('order.shipped');
            Route::get('/order/out-for-delivery/',[OrderController::class,'out_for_deliveryOrders'])->name('order.out-for-delivery');
            Route::get('/order/delivered/',[OrderController::class,'deliveredOrders'])->name('order.delivered');
            Route::get('/order/canceled/',[OrderController::class,'canceledOrders'])->name('order.canceled');
        ############################## Order Status  End  ###################################


        Route::put('/order/change-payment-status/',[OrderController::class,'change_payment_status'])->name('order.change-payment-status');
        Route::get('/order/change-order-status/',[OrderController::class,'change_order_status'])->name('order.change-order-status');
        Route::get('/order/trashed-orders/',[OrderController::class,'trashed_orders'])->name('order.trashed-orders');
        Route::get('/order/trashed-orders/{id}/restore',[OrderController::class,'trashed_orders_restore'])->name('order.trashed-orders.restore');
        Route::get('/order/trashed-orders/{id}/force-delete',[OrderController::class,'trashed_orders_delete'])->name('order.trashed-orders.delete');
        // Route::resource('order',OrderController::class);
        Route::resource('order',OrderController::class)->except(['store','edit','update']);

    ############################## Order  End  ###################################


    ############################## Transaction  Start  ###################################
    Route::get('/transactions',[TransactionController::class,'index'])->name('transaction.index');
    ############################## Transaction  End  ###################################
    
    
    
    ############################## Home Page Settings  Start  ###################################
    Route::group(['prefix'=>'home-page-setting','as'=>'home-page-setting.'],function(){

        Route::get('/',[HomePageSettingController::class,'index'])->name('index');
        Route::put('popular-category/update',[HomePageSettingController::class , 'UpdatePopularCategory'])->name('popular-category.update');
        Route::put('product-slider-section-one/update',[HomePageSettingController::class , 'UpdateProductSliderSectionOne'])->name('product-slider-section-one.update');
        Route::put('product-slider-section-two/update',[HomePageSettingController::class , 'UpdateProductSliderSectionTwo'])->name('product-slider-section-two.update');
        Route::put('weekly-best-products/update',[HomePageSettingController::class , 'UpdateWeeklyBestProducts'])->name('weekly-best-products.update');
    
        Route::get('list-view',[HomePageSettingController::class , 'changeViewList'])->name('view-list');

        Route::get('/get-sub-categories',[HomePageSettingController::class,'get_subcategories'])->name('get-sub-categories');
        Route::get('/get-child-categories',[HomePageSettingController::class,'get_childcategories'])->name('get-child-categories');
    
    });
    ############################## Home Page Settings  End  ###################################
    
    
    
    

    ############################## Footer  Start  ###################################

        ############################## Footer Information  Start  ###################################
            Route::get('footer-info',[FooterInfoController::class , 'index'])->name('footer-info.index');
            Route::post('footer-info',[FooterInfoController::class , 'update'])->name('footer-info.update');

        ############################## Footer Information  End  ###################################

        ############################## Footer Socials  Start  ###################################
            Route::put('footer-socials/change-status/',[FooterSocialController::class,'change_status'])->name('footer-socials.change-status');
            Route::resource('footer-socials',FooterSocialController::class);
        ############################## Footer Socials  End  ###################################
            
        ############################## Footer Grid Two  Start  ###################################
            Route::put('footer-grid-two/change-status/',[FooterGridTwoController::class,'change_status'])->name('footer-grid-two.change-status');
            Route::put('footer-grid-two/change-title/',[FooterGridTwoController::class,'changeTitle'])->name('footer-grid-two.change-title');
            Route::resource('footer-grid-two',FooterGridTwoController::class);
        ############################## Footer Grid Two   End  ###################################

        ############################## Footer Grid Three  Start  ###################################
            Route::put('footer-grid-three/change-status/',[FooterGridThreeController::class,'change_status'])->name('footer-grid-three.change-status');
            Route::put('footer-grid-three/change-title/',[FooterGridThreeController::class,'changeTitle'])->name('footer-grid-three.change-title');
            Route::resource('footer-grid-three',FooterGridThreeController::class);
        ############################## Footer Grid Three   End  ###################################

        ############################## Newsletter Subscriber  Start  ###################################
            Route::get('subscriber/',[SubscriberController::class,'index'])->name('subscriber.index');
            Route::delete('subscriber/{id}/destory',[SubscriberController::class,'destroy'])->name('subscriber.destroy');

            Route::post('subscriber/send-mail',[SubscriberController::class ,'sendMail'])->name('subscriber.send-mail');
        ############################## Newsletter Subscriber   End  ###################################

    ############################## Footer  End  ###################################


    ############################## advertisements  Start  ###################################

    Route::group(['prefix'=>'advertisement','as'=>'advertisement.'],function(){

        Route::get('',[AdvertisementController::class ,'index'])->name('index');
    
        
        Route::put('/homepage-banner-section-one',[AdvertisementController::class ,'homepageBannerSectionOne'])->name('homepage-banner-section-one');
        Route::put('/homepage-banner-section-two',[AdvertisementController::class ,'homepageBannerSectionTwo'])->name('homepage-banner-section-two');
        Route::put('/homepage-banner-section-three',[AdvertisementController::class ,'homepageBannerSectionThree'])->name('homepage-banner-section-three');
        Route::put('/homepage-banner-section-four',[AdvertisementController::class ,'homepageBannerSectionFour'])->name('homepage-banner-section-four');

        Route::put('/productpage-banner',[AdvertisementController::class ,'productpageBanner'])->name('productpage-banner');
        Route::put('/cartpage-banner',[AdvertisementController::class ,'cartpageBanner'])->name('cartpage-banner');
    
    
        Route::get('/list-view',[AdvertisementController::class , 'changeViewList'])->name('view-list');
    });

    ############################## advertisements  End  ###################################


    ##############################  Review Start  ###################################
    route::get('/product-review',[AdminProductReviewController::class,'index'])->name('product-review.index');
    Route::put('product-review/change-status/',[AdminProductReviewController::class,'change_status'])->name('product-review.change-status');
    route::delete('/product-review/{id}/destroy',[AdminProductReviewController::class,'destroy'])->name('product-review.destory');
    route::get('/product-review/{id}/Gallery',[AdminProductReviewController::class,'productReviewGallery'])->name('product-review-gallery');
    route::delete('/product-review/Gallery/{id}/destroy',[AdminProductReviewController::class,'productReviewGalleryDestroy'])->name('product-review-gallery.destroy');
    ##############################  Review End  ###################################
    
    
    
    ##############################  Vendor Request Start  ###################################
    Route::get('vendor-request',[VendorRequestController::class ,'index'])->name('vendor-request.index');
    Route::get('vendor-request/{id}/show',[VendorRequestController::class ,'show'])->name('vendor-request.show');
    Route::get('/vendor-request/pending/',[VendorRequestController::class,'pendingVendorRequest'])->name('vendor-request.pending');
    Route::get('/vendor-request/Approved/',[VendorRequestController::class,'ApprovedVendorRequest'])->name('vendor-request.approved');
    Route::post('/vendor-request/{id}/change-status',[VendorRequestController::class,'changeStatus'])->name('vendor-request.change-status');

    ##############################  Vendor Request End  ###################################


    ##############################  Customer (client) List Start  ###################################
    Route::get('customer-list',[CustomerListController::class ,'index'])->name('customer-list.index');
    Route::put('customer-list/change-status',[CustomerListController::class,'change_status'])->name('customer-list.change-status');
    
    ##############################  Customer (client) List End  ###################################
    ##############################  Vendor List Start  ###################################
    
    Route::get('vendor-list',[VendorListController::class ,'index'])->name('vendor-list.index');
    Route::put('vendor-list/change-status',[VendorListController::class,'change_status'])->name('vendor-list.change-status');
    
    ##############################  Vendor List End  ###################################


    ##############################  Vendor Conditions Start  ###################################
    Route::get('vendor-condition',[VendorConditionController::class , 'index'])->name('vendor-condition.index');
    Route::put('vendor-condition/update',[VendorConditionController::class , 'updateVendorCondition'])->name('vendor-condition.update');

    ##############################  Vendor Conditions End  ###################################

    ##############################  Vendor Conditions Start  ###################################
    Route::get('about',[AboutController::class , 'index'])->name('about.index');
    Route::put('about/update',[AboutController::class , 'updateAbout'])->name('about.update');

    ##############################  Vendor Conditions End  ###################################
    
    ##############################  Vendor Conditions Start  ###################################
    Route::get('terms-and-conditions',[TermAndConditionController::class , 'index'])->name('terms-and-conditions.index');
    Route::put('terms-and-conditions/update',[TermAndConditionController::class , 'updateTermsAndConditions'])->name('terms-and-conditions.update');

    ##############################  Vendor Conditions End  ###################################
    
    
    ##############################  Manage-user Start  ###################################
    Route::get('manage-user',[ManageUserController::class , 'index'])->name('manage-user.index');
    Route::post('manage-user/store',[ManageUserController::class , 'store'])->name('manage-user.store');

    ##############################  Manage-user End  ###################################
    


    ##############################  Admin List Start  ###################################
    
    Route::get('admin-list',[AdminListController::class ,'index'])->name('admin-list.index');
    Route::put('admin-list/change-status',[AdminListController::class,'change_status'])->name('admin-list.change-status');
    route::delete('admin-list/{id}/destroy',[AdminListController::class,'destroy'])->name('admin-list.destroy');
    
    ##############################  Admin List End  ###################################


    ##############################  Blog  Start  ###################################

    Route::put('/blog/change-status/',[BlogController::class,'change_status'])->name('blog.change-status');
    Route::resource('blog',BlogController::class);

        ##############################  Blog Category Start  ###################################
        Route::put('/blog-category/change-status/',[BlogCategoryController::class,'change_status'])->name('blog-category.change-status');
        Route::resource('blog-category',BlogCategoryController::class);
        ##############################  Blog Category End  ###################################

        ##############################  Blog Comments Start  ###################################
        Route::get('blog-comment',[BlogCommentController::class,'index'])->name('blog-comment.index');
        Route::delete('blog-comment/{id}/destroy',[BlogCommentController::class,'destroy'])->name('blog-comment.destroy');
        ##############################  Blog Comments End  ###################################


    ##############################  Blog  End  ###################################





});