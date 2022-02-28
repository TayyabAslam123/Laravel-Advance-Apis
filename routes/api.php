<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

##buyer
Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);
Route::resource('buyer.transactions','Buyer\BuyerTransactionController',['only'=>['index']]);
Route::resource('buyer.products','Buyer\BuyerProductController',['only'=>['index']]);
Route::resource('buyer.sellers','Buyer\BuyerSellerController',['only'=>['index']]);
Route::resource('buyer.categories','Buyer\BuyerCategoryController',['only'=>['index']]);
##seller
Route::resource('sellers','Seller\SellerController',['only'=>['index','show']]);
Route::resource('sellers.transactions','Seller\SellerTransactionController',['only'=>['index','show']]);
Route::resource('sellers.categories','Seller\SellerCategoryController',['only'=>['index','show']]);
Route::resource('sellers.buyers','Seller\SellerBuyerController',['only'=>['index','show']]);
Route::resource('sellers.products','Seller\SellerProductController');

##transaction
Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]);
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only'=>['index']]);
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only'=>['index']]);
##products
Route::resource('products','Product\ProductController',['only'=>['index','show']]);
Route::resource('products.transactions','Product\ProductTransactionController',['only'=>['index']]);
Route::resource('products.buyers','Product\ProductBuyerController',['only'=>['index']]);
Route::resource('products.categories','Product\ProductCategoryController');
Route::resource('products.buyers.transactions','Product\ProductBuyerTransactionController',['only'=>['store']]);
##categories
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('categories.products','Category\CategoryProductController',['only'=>['index']]);
Route::resource('categories.sellers','Category\CategorySellerController',['only'=>['index']]);
Route::resource('categories.transactions','Category\CategoryTransactionController',['only'=>['index']]);
Route::resource('categories.buyer','Category\CategoryBuyerController',['only'=>['index']]);
##user
Route::resource('users','User\UserController',['except'=>['create','edit']]);
Route::name('verify')->get('user/verify/{token}','User\UserController@verify');
Route::name('resend')->get('user/{user}/resend','User\UserController@resend');