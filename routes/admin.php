<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\SliderController;
use App\Http\Controllers\Backend\Admin\CategoryController;
use App\Http\Controllers\Backend\Admin\SubcategoryController;

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


});