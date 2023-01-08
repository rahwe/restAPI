<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryBuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Category\CategoryTransactionController;
use App\Http\Controllers\Product\ProductBuyerTransactionController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('/v1/buyers', BuyerController::class)->only(['index', 'show']);
Route::resource('/v1/buyers.transactions', BuyerTransactionController::class)->only(['index']);
Route::resource('/v1/buyers.products', BuyerProductController::class)->only(['index']);
Route::resource('/v1/buyers.sellers', BuyerSellerController::class)->only(['index']);
Route::resource('/v1/buyers.categories', BuyerCategoryController::class)->only(['index']);



Route::resource('/v1/categories', CategoryController::class)->except(['create', 'edit']);
Route::resource('/v1/categories.products', CategoryProductController::class)->only(['index']);
Route::resource('/v1/categories.sellers', CategorySellerController::class)->only(['index']);
Route::resource('/v1/categories.transactions', CategoryTransactionController::class)->only(['index']);
Route::resource('/v1/categories.buyers', CategoryBuyerController::class)->only(['index']);


Route::resource('/v1/sellers', SellerController::class)->only(['index', 'show']);
Route::resource('/v1/sellers.transactions', SellerTransactionController::class)->only(['index']);
Route::resource('/v1/sellers.categories', SellerCategoryController::class)->only(['index']);
Route::resource('/v1/sellers.buyers', SellerBuyerController::class)->only(['index']);
Route::resource('/v1/sellers.products', SellerProductController::class)->except(['create', 'show', 'edit']);



Route::resource('/v1/products', ProductController::class)->only(['index', 'show']);
Route::resource('/v1/products.categories', ProductCategoryController::class)->only(['index', 'update', 'destroy']);
Route::resource('/v1/products.buyers.transactions', ProductBuyerTransactionController::class)->only(['store']);


Route::resource('/v1/transactions', TransactionController::class)->only(['index', 'show']);
Route::resource('/v1/transactions.categories', TransactionCategoryController::class)->only(['index']);
Route::resource('/v1/transactions.sellers', TransactionSellerController::class)->only(['index']);



Route::resource('/v1/users', UserController::class)->except(['create', 'edit']);
Route::get('/v1/users/verify/{token}', [UserController::class, 'verify'])->name('verify');
Route::get('/v1/users/{user}/resend', [UserController::class, 'resend'])->name('resend');


Route::post('oauth/token', 'Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
Route::post('oauth/token/refresh', 'Laravel\Passport\Http\Controllers\TransientTokenController@refresh');






