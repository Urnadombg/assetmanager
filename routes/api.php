<?php

use Illuminate\Http\Request;
use App\Http\Resources\Asets as AsetsResource;
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

Route::get('/test', function () {
//    $assets = new \App\Http\Resources\AssetCollection(\App\Asset::with(['components','customer','media']));

//    $ass = \App\Http\Resources\Warranties::collection(\App\Warranty::all());
//    return $ass;

//    $asset = \App\Asset::find(1)->additionals;
//    return response()->json($asset);
    $uds = \Ramsey\Uuid\Uuid::uuid4();
    return $uds;
});

Route::prefix('/assets')->group(function () {
    Route::get('/', 'API\\AssetController@index');
    Route::get('/{id}', 'API\\AssetController@show');
    Route::post('/', 'API\\AssetController@store');
    Route::put('/{id}', 'API\\AssetController@update');
    Route::post('/uploadFile', 'API\\AssetController@saveAssetMedia');
    Route::post('/search/{search}', 'API\\AssetController@search');
});
Route::prefix('/components')->group(function () {
    Route::get('/', 'API\\ComponentController@index');
    Route::get('/{id}', 'API\\ComponentController@show');
    Route::post('/', 'API\\ComponentController@store');
});
Route::prefix('/customers')->group(function () {
    Route::get('/', 'API\\CustomerController@index');
});
