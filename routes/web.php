<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'adminauth'])->group(function () {
    Route::prefix('/code')->group(function () {
        Route::get('/new', 'products\QRCodeController@openNewQRCodeFormPage')->name('qrcode_new');
        Route::post('/new', 'products\QRCodeController@generateNewQRCodes')->name('qrcode_generate');
        Route::get('/list', 'products\QRCodeController@openQRCodeList')->name('qrcode_list');
    });
    Route::prefix('company')->group(function () {
        Route::get('/new', 'companies\CargoCompanyController@openNewCargoCompanyFormPage')->name('new_cargo_company_form');
        Route::post('/new', 'companies\CargoCompanyController@addNewCargoCompany')->name('new_cargo_company_form');
        Route::get('/list', 'companies\CargoCompanyController@viewListCargoCompanies')->name('view_list_cargo_companies');
    });
    Route::get('/home', function () {
        return view('dashboard');
    })->name('home_page');
});

Route::middleware('compweb')->group(function () {

    Route::get('/', 'companies\CargoCompanyController@openIndexPage')->name('welcome');
    Route::prefix('/cargo')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/shipments', 'companies\CargoShipmentController@latestShipmentsView');
        Route::get('/shipments/delivered', 'companies\CargoShipmentController@deliveredtShipmentsView');
        Route::get('/shipments/{id}/{tracking_number}', 'companies\CargoShipmentController@getShipmentDetails');
        Route::get('/shipments/view/{id}/{tracking_number}', 'companies\CargoShipmentController@viewShipmentDetails');
    });
});
Route::post('cargo/logout', 'companies\CargoCompanyController@logoutCompany')->name('cargologout');
Route::post('/cargo/login', 'companies\CargoCompanyController@loginCompany')->name('login_company');

Route::get('/cargo/login', 'companies\CargoCompanyController@loginPage')->name('company_login');
Auth::routes();
