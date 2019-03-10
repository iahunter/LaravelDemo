<?php

use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection; 
use App\Model\Product; 

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Add route Resources for Products
//Route::Resource('/products','ProductController'); 

// Add only API routes for Products
Route::apiResource('/products','ProductController'); 

// Custom API routes for Reviews
Route::group(['prefix' => 'products'], function(){
	Route::apiResource('/{product}/reviews', 'ReviewController'); 
}); 