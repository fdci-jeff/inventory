<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/sales-purchases/chart-data', [App\Http\Controllers\HomeController::class, 'salesPurchasesChart'])->name('sales-purchases.chart');
    Route::get('/current-month/chart-data', [App\Http\Controllers\HomeController::class, 'currentMonthChart'])->name('current-month.chart');
    Route::get('/payment-flow/chart-data', [App\Http\Controllers\HomeController::class, 'paymentChart'])->name('payment-flow.chart');

    // Sale Route
    Route::prefix('sale')->name('sale.')->group(function () {
        Route::get('/pos', [App\Http\Controllers\Sale\PosController::class, 'index'])->name('pos.index');
    });

    // Customer Route
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/create', [App\Http\Controllers\Customer\CustomerController::class, 'create'])->name('create');
        Route::get('/index', [App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('index');
        Route::post('/store', [App\Http\Controllers\Customer\CustomerController::class, 'store'])->name('store');
    });
});
