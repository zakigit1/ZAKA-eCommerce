<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Vendor\VendorController;
use App\Http\Controllers\Backend\Vendor\VendorOrderController;
use App\Http\Controllers\Backend\Vendor\VendorProduct\VendorProductController;
use App\Http\Controllers\Backend\Vendor\VendorProduct\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\Vendor\VendorProduct\VendorProductVariantController;
use App\Http\Controllers\Backend\Vendor\VendorProduct\VendorProductVariantItemController;
use App\Http\Controllers\Backend\Vendor\VendorProductReviewController;
use App\Http\Controllers\Backend\Vendor\VendorShopProfileController;
use App\Http\Controllers\Backend\Vendor\VendorWithdrawController;

// Route::get('vendor/dashboard',[VendorController::class,'index'])->middleware(['auth:web','role:vendor'])->name('vendor.dashboard');


Route::group(['middleware'=>['auth:web','role:vendor'],'prefix'=>'vendor','as'=>'vendor.'],function(){


        Route::get('dashboard',[VendorController::class,'index'])->name('dashboard');
        Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/profile', [VendorController::class,'profile'])->name('profile');
        Route::post('/profile/update', [VendorController::class,'update_profile'])->name('profile.update');
        Route::post('/profile/update/password', [VendorController::class,'update_profile_password'])->name('profile.update.password');



    ##############################  Vendor Profile Start  ###################################

        Route::group(['prefix'=>'shop-profile','as'=>'shop-profile.'],function(){
            Route::get('/',[VendorShopProfileController::class,'index'])->name('index');
            Route::post('/update',[VendorShopProfileController::class,'update_vendor_profile'])->name('update');
        });
    ##############################  Vendor Profile Start  ###################################


    ##############################  Vendor Product Start  ###################################

        Route::group(['prefix'=>'product','as'=>'product.'],function(){
            Route::get('/',[VendorProductController::class,'index'])->name('index');
            Route::get('create',[VendorProductController::class,'create'])->name('create');
            Route::post('store',[VendorProductController::class,'store'])->name('store');
            Route::get('/{id}/edit',[VendorProductController::class,'edit'])->name('edit');
            Route::post('{id}/update',[VendorProductController::class,'update'])->name('update');
            Route::DELETE('{id}/destroy',[VendorProductController::class,'destroy'])->name('destroy');
            Route::put('change-status',[VendorProductController::class,'change_status'])->name('change-status');
            Route::get('get-sub-categories',[VendorProductController::class,'get_subcategories'])->name('get-sub-categories');
            Route::get('get-child-categories',[VendorProductController::class,'get_childcategories'])->name('get-child-categories');
        });

        Route::group(['prefix'=>'product-image-gallery','as'=>'product-image-gallery.'],function(){
            Route::get('/',[VendorProductImageGalleryController::class,'index'])->name('index');
            Route::post('store',[VendorProductImageGalleryController::class,'store'])->name('store');
            Route::get('/{id}/edit',[VendorProductImageGalleryController::class,'edit'])->name('edit');
            Route::post('{id}/update',[VendorProductImageGalleryController::class,'update'])->name('update');
            Route::DELETE('{id}/destroy',[VendorProductImageGalleryController::class,'destroy'])->name('destroy');
            Route::DELETE('{id}/destroyAll',[VendorProductImageGalleryController::class,'destroyAllImages'])->name('destroy-all-images');
            
        });

        Route::group(['prefix'=>'product-variant','as'=>'product-variant.'],function(){
            Route::get('/',[VendorProductVariantController::class,'index'])->name('index');
            Route::get('create',[VendorProductVariantController::class,'create'])->name('create');
            Route::post('store',[VendorProductVariantController::class,'store'])->name('store');
            Route::get('/{id}/edit',[VendorProductVariantController::class,'edit'])->name('edit');
            Route::post('{id}/update',[VendorProductVariantController::class,'update'])->name('update');
            Route::DELETE('{id}/destroy',[VendorProductVariantController::class,'destroy'])->name('destroy');
            Route::put('change-status',[VendorProductVariantController::class,'change_status'])->name('change-status');
            
        });
        Route::group(['prefix'=>'product-variant-item','as'=>'product-variant-item.'],function(){

            Route::get('/{productId}/{variantId}',[VendorProductVariantItemController::class,'index'])->name('index');
            Route::get('create/{productId}/{variantId}',[VendorProductVariantItemController::class,'create'])->name('create');
            Route::post('store',[VendorProductVariantItemController::class,'store'])->name('store');
            Route::get('/{itemId}/edit/edit',[VendorProductVariantItemController::class,'edit'])->name('edit');
            Route::post('{itemId}/update',[VendorProductVariantItemController::class,'update'])->name('update');
            Route::DELETE('{itemId}/destroy',[VendorProductVariantItemController::class,'destroy'])->name('destroy');
            Route::put('change-status',[VendorProductVariantItemController::class,'change_status'])->name('change-status');
            
        });

        ##############################  Product End  ###################################

    ##############################  Vendor Product End  ###################################
    ##############################  Vendor Orders Start  ###################################

    
    Route::get('/order/change-order-status/',[VendorOrderController::class,'change_order_status'])->name('order.change-order-status');

    Route::get('/order/trashed-orders/',action: [VendorOrderController::class,'trashed_orders'])->name('order.trashed-orders');
    Route::get('/order/trashed-orders/{id}/restore',[VendorOrderController::class,'trashed_orders_restore'])->name('order.trashed-orders.restore');
    Route::get('/order/trashed-orders/{id}/force-delete',[VendorOrderController::class,'trashed_orders_delete'])->name('order.trashed-orders.delete');
   
    Route::resource('order',VendorOrderController::class)->except(['store','edit','update']);

    ##############################  Vendor Orders End  ###################################
    
    ##############################  Review Start  ###################################
    route::get('/product-review',[VendorProductReviewController::class,'index'])->name(name: 'product-review.index');
    ##############################  Review End  ###################################


    ##############################  Withdraw Start  ###################################
    Route::get('withdraw/{id}/withdraw-method-details',[VendorWithdrawController::class,'withdrawMethodDetails'])->name('withdraw.withdraw-method-details');
    Route::resource('withdraw',VendorWithdrawController::class);
    ##############################  Withdraw End  ###################################








    
});





