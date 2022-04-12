<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('user/login', 'App\Http\Controllers\Auth\AuthController@login')->name('login.form');
    Route::post('user/login', 'App\Http\Controllers\Auth\AuthController@authenticate')->name('login.submit');

    Route::get('user/register', 'App\Http\Controllers\Auth\AuthController@register')->name('register.form');
    Route::post('user/register', 'App\Http\Controllers\Auth\AuthController@registerSubmit')->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', 'App\Http\Controllers\Auth\AuthController@logout')->name('user.logout');
});



// Frontend Routes
Route::get('/', 'App\Http\Controllers\Front\FrontendController@home')->name('home');

Route::get('product-detail/{id}', 'App\Http\Controllers\Front\FrontendController@productDetail')->name('product-detail');
Route::get('/product-grids', 'App\Http\Controllers\Front\FrontendController@productGrids')->name('product-grids');
Route::get('/filter', 'App\Http\Controllers\Front\FrontendController@productFilter')->name('shop.filter');

Route::middleware(['auth','client'])->group(function () {
    // Cart section
    Route::get('/cart','App\Http\Controllers\Front\CartController@getCart')->name('cart');
    Route::get('/checkout', 'App\Http\Controllers\Front\CartController@checkout')->name('checkout');
    Route::post('/add-to-cart', 'App\Http\Controllers\Front\CartController@addToCart')->name('single-add-to-cart');
    Route::get('/add-to-cart/{id}', 'App\Http\Controllers\Front\CartController@singleAddToCart')->name('add-to-cart');
    Route::get('cart-delete/{id}', 'App\Http\Controllers\Front\CartController@cartDelete')->name('cart-delete');
    Route::post('cart-update', 'App\Http\Controllers\Front\CartController@cartUpdate')->name('cart.update');
});


Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'App\Http\Controllers\Admin\AdminController@index')->name('admin');

    // user route
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');

    // Category
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    // Product
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    //sub_categories
    Route::get('/api/categories/{id}/sub_categories', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'getByCategory']);

    Route::get('/categories/{id}/sub_categories', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'getByCategoryIndex'])->name('sub_category.index');
    Route::get('/sub_categories/{id}/edit', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'edit'])->name('sub_category.edit');
    Route::get('/sub_categories/create', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'create'])->name('sub_category.create');
    Route::post('/sub_categories', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'store'])->name('sub_category.store');
    Route::delete('/sub_categories/{id}', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'destroy'])->name('sub_category.destroy');
    Route::patch('/sub_categories/{id}', [\App\Http\Controllers\Admin\Sub_categoryController::class, 'update'])->name('sub_category.update');
});
