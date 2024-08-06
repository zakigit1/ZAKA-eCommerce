<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\AdminVendroProfileController;
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

    ##############################  Vendor Profile Start  ###################################

        Route::group(['prefix'=>'vendor-profile','as'=>'vendor-profile.'],function(){
            
            Route::get('/',[AdminVendroProfileController::class,'index'])->name('index');
            Route::post('/update',[AdminVendroProfileController::class,'update_admin_vendor_profile'])->name('update');


        });



   
    ##############################  Vendor Profile End  ###################################

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
        Route::put('/general-settings/update',[SettingController::class , 'UpdateSettingsGeneral'])->name('general-settings.update');


    });
    
    ############################## Settings  End  ###################################

});