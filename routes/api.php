<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('createProduct','ProductController@store');

Route::get('categories', 'CategoryController@index');
Route::get('products', 'ProductController@index');
Route::get('getCategories', 'CategoryController@getCategories');
Route::get('prices', 'PriceController@index');

Route::get('search/{name}', 'ProductController@search');