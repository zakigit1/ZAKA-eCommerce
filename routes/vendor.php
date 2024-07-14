<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Vendor\VendorController;


// Route::get('vendor/dashboard',[VendorController::class,'index'])->middleware(['auth:web','role:vendor'])->name('vendor.dashboard');


Route::group(['middleware'=>['auth:web','role:vendor'],'prefix'=>'vendor','as'=>'vendor.'],function(){


    Route::get('dashboard',[VendorController::class,'index'])->name('dashboard');
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/profile', [VendorController::class,'profile'])->name('profile');
    Route::post('/profile/update', [VendorController::class,'update_profile'])->name('profile.update');
    Route::post('/profile/update/password', [VendorController::class,'update_profile_password'])->name('profile.update.password');


});