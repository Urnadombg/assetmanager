<?php

use App\Asset;
use App\Maintenance;
use DemeterChain\Main;
use Illuminate\Http\Request;
use App\Http\Resources\Asets as AsetsResource;
use Illuminate\Support\Facades\DB;

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

Route::get('/test/', function () {
    $asder = Asset::findOrFail(212)->load(['customer']);
    $customer = \App\Customer::findOrFail($asder->customer->id);
//    $newCustomerId = ;
    dd($customer);
////    dd(storage_path());
//    $phpWord  = new PhpOffice\PhpWord\PhpWord();
//    $template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path() . '/Garancionna-karta.docx');
//
//    $template->setValues([
//        'assetTitle' => 'Дентален лазер за твърди и меки тъкани',
//        'assetModel' => 'LiteTouch 3',
//        'serialNumber' => 'SH1234123412345',
//        'protocolDate' => '2010-10-01',
//        'customer' => 'Д-р Иванка Киркова',
//        'customerAddress' => '',
//        'customerPhone' => '',
//        'cartDate' => \Carbon\Carbon::today(),
//        'period' => \Carbon\Carbon::parse(\Carbon\Carbon::today()->addMonths(25))->diffInMonths(),
////        'customerAddress' => 'Lite',
//    ]);
//
//
//    $template->saveAs(storage_path() . '/n0va.docx');
//
//
////    $section = $phpWord ->addSection();
////// Adding Text element to the Section having font styled by default...
////    $header = $section->addHeader();
////    $header->addText('гр. Пловдив, бул. "Васил Априлов" № 92, тел.: 0700 10 95 95; '.
////    'гр. София, бул. "Васил Априлов" № 92, тел.: 0700 10 95 95; '.
////    'гр. Варна, бул. "Васил Априлов" № 92, тел.: 0700 10 95 95; ', null, ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
////    $section->addText('ГАРАНЦИОННА КАРТA',['bold' => true,'size' => 22], ['size' => 28, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
////    $section->addText('№12345678990123 / 10.10.2030',['italic' => true], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
////
////    // footer
////    $footer = $section->addFooter();
////    $footer->addPreserveText('стр. {PAGE} от {NUMPAGES}' );
////    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
////
//////    \PhpOffice\PhpWord\Settings::setPdfRendererName('dompdf');
////
////    $objWriter->save(storage_path() . '/helloWorld.docx');
////    return response()->view('pdf');
});

Route::prefix('/assets')->group(function () {
    Route::get('/', 'API\\AssetController@index');
    Route::get('/{id}', 'API\\AssetController@show');
    Route::delete('/{id}', 'API\\AssetController@destroy');
    Route::post('/', 'API\\AssetController@store');
    Route::put('/{id}', 'API\\AssetController@update');
    Route::post('/uploadFile', 'API\\AssetController@saveAssetMedia');
    Route::get('/search/{search}', 'API\\AssetController@search');
    Route::post('/newMaintenance', 'API\\AssetController@createMaintenanceProtocol');
    Route::post('/addComponentToAsset', 'API\\AssetController@addComponentToAsset');
    Route::post('/createWarranty/{id}', 'API\\AssetController@createWarranty');
    Route::post('/changeOwner', 'API\\AssetController@changeOwner');
});
Route::prefix('/components')->group(function () {
    Route::get('/', 'API\\ComponentController@index');
    Route::get('/{id}', 'API\\ComponentController@show');
    Route::post('/', 'API\\ComponentController@store');
});
Route::prefix('/customers')->group(function () {
    Route::get('/', 'API\\CustomerController@index');
    Route::get('/{id}', 'API\\CustomerController@show');
    Route::post('/', 'API\\CustomerController@store');
});

Route::prefix('/maintenances')->group(function () {
    Route::post('/', 'API\\MaintenanceController@store');
    Route::get('/getRmaNumber', 'API\\MaintenanceController@getRmaNumber');
    Route::patch('/{id}/setStatus', 'API\\MaintenanceController@setCaseStatus');
});
