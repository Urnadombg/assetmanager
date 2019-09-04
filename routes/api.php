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
    $cus = App\Customer::find(1)->load('companies');
//    dd($cus->IsLegalEntity ? "DA" : "NE");
    return response()->json($cus);
});

Route::prefix('/assets')->group(function () {
    Route::get('/', 'API\\AssetController@index');
    Route::get('/{id}', 'API\\AssetController@show');
    Route::post('/', 'API\\AssetController@store');
    Route::put('/{id}', 'API\\AssetController@update');
    Route::post('/uploadFile', 'API\\AssetController@saveAssetMedia');
    Route::post('/search/{search}', 'API\\AssetController@search');
    Route::post('/newMaintenance', 'API\\AssetController@createMaintenanceProtocol');
});
Route::prefix('/components')->group(function () {
    Route::get('/', 'API\\ComponentController@index');
    Route::get('/{id}', 'API\\ComponentController@show');
    Route::post('/', 'API\\ComponentController@store');
});
Route::prefix('/customers')->group(function () {
    Route::get('/', 'API\\CustomerController@index');
});

Route::prefix('/maintenance')->group(function () {
    Route::post('/', 'API\\MaintenanceController@createNewRecord');
});
