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

Route::get('/', function () {
    return view('welcome');
});
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
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
