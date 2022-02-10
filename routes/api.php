<?php

use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/products', 'ProductController@index');

    Route::get('/products/paginate/{paginate}', 'ProductController@paginate');

    Route::post('/add_product', 'ProductController@store');

    Route::get('/product/{id}', 'ProductController@show');

    Route::put('/product/update/{id}', 'ProductController@update');

    Route::delete('/product/{id}', 'ProductController@destroy');

    Route::get('product/search/{name?}', 'ProductController@search');

    Route::post('user/logout', 'AuthController@logout');
    Route::post('product/{product_id}/add_to_cart', 'ProductController@addToCart');

    Route::get('show_cart', 'ProductController@getIndividualCart');
    Route::get('show_cart_all', 'ProductController@getAllCart');


    Route::put('product/{product_id}/updateCart', 'ProductController@updateCart');


});

Route::post('user/register_user', 'AuthController@register');

Route::post('user/login', 'AuthController@login');


