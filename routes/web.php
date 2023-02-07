<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

Route::get('/admin', [AdminController::class, 'admin']);

Route::get('/addcategory', [CategoryController::class, 'addcategory']);
Route::post('/savecategory', [CategoryController::class, 'savecategory']);
Route::get('/categories', [CategoryController::class, 'categories']);
Route::get('/edit_category/{id}', [CategoryController::class, 'edit_category']);
Route::post('/updatecategory', [CategoryController::class, 'updatecategory']);
Route::get('/delete_category/{id}', [CategoryController::class, 'deletecategory']);

Route::get('/addslider', [SliderController::class, 'addslider']);
Route::get('/sliders', [SliderController::class, 'sliders']);
Route::post('/saveslider', [SliderController::class, 'saveslider']);
Route::get('/edit_slider/{id}', [SliderController::class, 'edit_slider']);
Route::post('/updateslider', [SliderController::class, 'updateslider']);
Route::get('/delete_slider/{id}', [SliderController::class, 'delete_slider']);
Route::get('/activate_slider/{id}', [SliderController::class, 'activate_slider']);
Route::get('/unactivate_slider/{id}', [SliderController::class, 'unactivate_slider']);

Route::get('/addproduct', [ProductController::class, 'addproduct']);
Route::post('/saveproduct', [ProductController::class, 'saveproduct']);
Route::get('/products', [ProductController::class, 'products']);
Route::get('/edit_product/{id}', [ProductController::class, 'edit_product']);
Route::post('/updateproduct', [ProductController::class, 'updateproduct']);
Route::get('/delete_product/{id}', [ProductController::class, 'delete_product']);
Route::get('/activate_product/{id}', [ProductController::class, 'activate_product']);
Route::get('/unactivate_product/{id}', [ProductController::class, 'unactivate_product']);
Route::get('/view_product_by_category/{category_name}', [ProductController::class, 'view_product_by_category']);
Route::get('/product_detail/{id}', [ProductController::class, 'product_detail']);

Route::get('/admin_signup', [AdminController::class, 'admin_signup']);
Route::get('/admin_login', [AdminController::class, 'admin_login']);
Route::post('/create_admin_account', [AdminController::class, 'create_admin_account']);
Route::post('/access_admin_account', [AdminController::class, 'access_admin_account']);
Route::get('/admin_logout', [AdminController::class, 'admin_logout']);
Route::get('/admin_accounts_view', [AdminController::class, 'admin_accounts_view']);
Route::get('/delete_admin/{id}', [AdminController::class, 'delete_admin']);
Route::get('/activate_account/{id}', [AdminController::class, 'activate_account']);
Route::get('/unactivate_account/{id}', [AdminController::class, 'unactivate_account']);

Route::get('/', [ClientController::class, 'home']);
Route::get('/shop', [ClientController::class, 'shop']);
Route::get('/wishlistItems', [ClientController::class, 'wishlistItems']);
Route::get('/wishlist', [ClientController::class, 'wishlist']);
Route::get('remove_wishlist_item/{id}', [ClientController::class, 'remove_wishlist_item']);
Route::post('/addFeedback', [ClientController::class, 'addFeedback']);
Route::get('/addtocart/{id}', [ClientController::class, 'addtocart']);
Route::post('/update_qty/{id}', [ClientController::class, 'update_qty']);
Route::get('/remove_from_cart/{id}', [ClientController::class, 'remove_from_cart']);
Route::get('/cart', [ClientController::class, 'cart']);
Route::get('/checkout', [ClientController::class, 'checkout']);
Route::get('/login', [ClientController::class, 'login']);
Route::get('/signup', [ClientController::class, 'signup']);
Route::post('/create_account', [ClientController::class, 'create_account']);
Route::post('/access_account', [ClientController::class, 'access_account']);
Route::get('/logout', [ClientController::class, 'logout']);
Route::post('/postcheckout', [ClientController::class, 'postcheckout']);
Route::get('/payment-success', [ClientController::class, 'payment_success']);
Route::get('/orders', [ClientController::class, 'orders']);
Route::get('/feedback', [ClientController::class, 'feedback']);
Route::get('/delete_feedback/{id}', [ClientController::class, 'delete_feedback']);
Route::get('/activate_feedback/{id}', [ClientController::class, 'activate_feedback']);
Route::get('/unactivate_feedback/{id}', [ClientController::class, 'unactivate_feedback']);

Route::get('/viewpdforder/{id}', [pdfController::class, 'view_pdf']);

