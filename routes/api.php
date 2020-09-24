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

Route::post('/authenticate', 'companies\CargoCompanyController@authenticateCompany');
Route::post('/track', 'companies\CargoShipmentController@getShipmentTrackStatus');
Route::middleware('companyAuth')->group(function () {
    Route::post('/addShipment', 'companies\CargoShipmentController@addNewShipment');
    Route::post('/addItem', 'companies\CargoShipmentController@addShipmentItem');
    Route::post('/shipments/today', 'companies\CargoShipmentController@getTodaysItems');
    Route::post('/shipments/pdf/today', 'companies\CargoShipmentController@getTodaysItemsPDF');
    Route::post('/shipments/pdf/delivered', 'companies\CargoShipmentController@getDeliveredItemsPDF');
    Route::post('/shipments/pdf/latest', 'companies\CargoShipmentController@getLatestItemsPDF');
    Route::post('/shipments/latest', 'companies\CargoShipmentController@getLatestItems');
    Route::post('/shipments/delivered', 'companies\CargoShipmentController@getLatestDelievered');
    Route::post('/track/timestamp', 'companies\CargoShipmentController@getGivenDateShipments');
});

Route::post('/update', 'companies\CargoShipmentController@getItemWithTrackingNumber');
Route::post('/update/{status}', 'companies\TrackingStatusController@updateStatus');

Route::post('/staff/authenticate', 'companies\CompanyStaffController@AuthenticatedStaff');
Route::post('/list/company', 'companies\CargoCompanyController@CargoCompaniesList');
