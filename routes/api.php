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

Route::post('/login', 'Api\LoginController@login');

Route::middleware(['jwt.verify'])->group(function () {

    Route::prefix('fetch')->group(function () {

        Route::prefix('users')->group(function () {
            Route::get('/customers', 'Api\CustomerController@fetchAllCustomers');

            });
        Route::get('/unpaid', 'Api\ApiController@fetchAllUnpaid');
        Route::get('/customers', 'Api\ApiController@fetchAllCustomers');
        Route::get('/package/{subscription_id}', 'Api\ApiController@fetchByPackageId');
        });
    });
    Route::prefix('store')->group(function () {
        Route::prefix('users')->group(function () {
            Route::post('/customers', 'Api\CustomerController@create');
        });
    });
    Route::prefix('delete')->group(function () {
        Route::prefix('users')->group(function () {
            Route::delete('/customers/{username}', 'Api\CustomerController@delete');
        });
    });
    Route::prefix('update')->group(function () {
        Route::prefix('users')->group(function () {
            Route::post('/customers/{username}', 'Api\CustomerController@update');
    });


});

Route::post('/customers/store', 'Api\ApiController@storeCustomer');
Route::post('/review/destroy/{review_id}', 'Api\ApiController@destroyReview');



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
