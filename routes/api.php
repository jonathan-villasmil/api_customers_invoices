<?php

// use App\Http\Controllers\Api\CustomerController;
// use App\Http\Controllers\Api\InvoiceController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//api/customers/invoices
Route::group(['namespace' => 'App\Http\Controllers\Api'], function (){
    Route::apiResource('/customers', CustomerController::class);
    Route::apiResource('/invoices', InvoiceController::class);

    Route::post('/invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
});



