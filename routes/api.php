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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', 'API\\AssetController@primaryAssets');

Route::prefix('/assets')->group(function () {
    Route::get('/', 'API\\AssetController@index');
    Route::get('/{id}', 'API\\AssetController@show');
    Route::post('/', 'API\\AssetController@store');
    Route::put('/{id}', 'API\\AssetController@update');
});
Route::prefix('/components')->group(function () {
    Route::get('/', 'API\\ComponentController@index');
    Route::get('/{id}', 'API\\ComponentController@show');
    Route::post('/', 'API\\ComponentController@store');
});
Route::prefix('/customers')->group(function () {
    Route::get('/', 'API\\CustomerController@index');
});
