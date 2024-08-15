<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\UserAddressController;
use App\Http\Controllers\Frontend\User\UserDashboard;
use App\Http\Controllers\Frontend\User\UserProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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


Route::group(['middleware'=>['auth','verified','role:user'],'prefix'=>'user','as'=>'user.'],function(){
    
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




});




    // ?   FlashSale :  
    Route::get('/flash-sale',[FlashSaleController::class,'index'])->name('flash-sale.index');

    // ?  Product Details
    Route::get('product-details/{slug}',[FrontendProductController::class , 'showProduct'])->name('product-details');
    
    // ?  Cart 
    
    Route::post('/add-to-cart',[CartController::class , 'addToCart'])->name('add-to-cart');
    Route::get('/cart',[CartController::class , 'cartDetails'])->name('cart');
    Route::post('/cart/update-qty',[CartController::class , 'quantityUpdate'])->name('cart-qty-update');
    
    Route::get('/cart/destroy/{rowId}',[CartController::class , 'removeProduct'])->name('remove-product-form-cart');
    Route::get('/cart/clear',[CartController::class , 'clearCart'])->name('clear-cart');
    Route::get('/cart/counter',[CartController::class , 'getCartCount'])->name('cart-counter');
    Route::get('/cart/get-products',[CartController::class , 'getCartProducts'])->name('cart-get-products');
    
    Route::post('/cart/sidebar/destroy',[CartController::class , 'removeSidebarProduct'])->name('remove-product-form-sidebar-cart');
    
    Route::get('/cart/sidebar-product/total',[CartController::class , 'cartTotalSidebar'])->name('cart-get-total-products-sidebar');











// Route::get('/register2',function(){
//     return view('Frontend.auth.register');
// })->name('front.register');




