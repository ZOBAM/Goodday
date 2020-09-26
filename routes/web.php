<?php

use Illuminate\Support\Facades\Route;
use App\User;

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
//$user = User::findOrFail(0);
Route::get('/', 'HomePageController@index')->name('homepage');
Auth::routes();
//clear cache
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
 });
Route::get('/ATriggerVerify.txt ', 'TriggerController@index');//trigger
Route::get('/sms-notification', 'NotificationsController@sms');
Route::post('/savings/{customer_Id?}/{action?}', 'SavingsController@StoreSavings')->middleware('auth');
//Route::get('/customers/{action?}', 'MainController@customers');
Route::post('/customers/{customer_id?}/{action?}', 'CustomersController@index')->middleware('auth');
//Route::get('/loans/{action?}', 'MainController@loans');
Route::post('/loans/{customer_id?}/{action?}', 'LoansController@StoreLoans')->middleware('auth');
//admin section
Route::post('/admin/{staff_id?}/{action?}', 'AdminController@index')->middleware('auth');
Route::post('/groups/{customer_id?}/{action?}', 'GroupController@index')->middleware('auth');
Route::get('/{section?}/{action?}/{customer_id?}', 'MainController@index')->middleware('auth');
//Route::get('/staffs/{action?}', 'MainController@staffs');
//Route::get('/home', 'MainController@index');



