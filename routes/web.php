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
Route::get('/', 'HomePageController@index')->name('homepage');
Auth::routes();
//Route::get('/savings/{action?}', 'MainController@savings');
Route::post('/savings/{customer_Id?}/{action?}', 'MainController@StoreSavings');
//Route::get('/customers/{action?}', 'MainController@customers');
Route::post('/customers/{customer_id?}', 'MainController@StoreCustomer');
//Route::get('/loans/{action?}', 'MainController@loans');
Route::post('/loans', 'MainController@StoreLoans');
Route::get('/{section?}/{action?}/{customer_id?}', 'MainController@index');
//Route::get('/staffs/{action?}', 'MainController@staffs');
//Route::get('/home', 'MainController@index');



