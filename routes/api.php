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

Route::get('customers', 'ApiCustomerController@index');
Route::post('customers', 'ApiCustomerController@store');
Route::get('customers/{customer}', 'ApiCustomerController@show');
Route::put('customers/{customer}', 'ApiCustomerController@update');
Route::delete('customers/{customer}', 'ApiCustomerController@delete');

Route::get('accounts', 'ApiAccountController@index');
Route::post('accounts', 'ApiAccountController@store');
Route::get('accounts/{account}', 'ApiAccountController@show');
Route::put('accounts/{account}', 'ApiAccountController@update');
Route::delete('accounts/{account}', 'ApiAccountController@delete');
Route::get('accounts/account_number/{account_number}','ApiAccountController@showByAccountNumber');

Route::post('transactions','ApiTransactionController@store');
Route::get('transactions','ApiTransactionController@index');