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

Route::get('/product', 'ProductController@index');
Route::post('/product', 'ProductController@create');

Route::get('/quote', 'QuoteController@index');
Route::get('/quote/{productType}', 'QuoteController@index')->where('productType', '[a-z0-9\-]+');
Route::post('/quote', 'QuoteController@create');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
