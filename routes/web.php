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

    // User Route
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    });

    // Products Route
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/categories', [App\Http\Controllers\Product\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories/store', [App\Http\Controllers\Product\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/create', [App\Http\Controllers\Product\ProductController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Product\ProductController::class, 'store'])->name('store');
        Route::get('/index', [App\Http\Controllers\Product\ProductController::class, 'index'])->name('index');
        Route::get('/show/{product}', [App\Http\Controllers\Product\ProductController::class, 'show'])->name('show');
    });

    //Dropzone Route
    Route::prefix('dropzone')->name('dropzone.')->group(function () {
        Route::post('/upload', [App\Http\Controllers\Upload\UploadController::class, 'dropzoneUpload'])->name('upload');
        Route::post('/delete', [App\Http\Controllers\Upload\UploadController::class, 'dropzoneDelete'])->name('delete');
    });

    // Barcode Route
    Route::prefix('barcode')->name('barcode.')->group(function () {
        Route::get('/print', [App\Http\Controllers\Barcode\BarcodeController::class, 'print'])->name('print');
        Route::get('/pdf', [App\Http\Controllers\Barcode\BarcodeController::class, 'pdf'])->name('pdf');
    });

    // Adjustment Route
    Route::prefix('adjustments')->name('adjustments.')->group(function() {
        Route::get('/create', [App\Http\Controllers\Adjustment\AdjustmentController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Adjustment\AdjustmentController::class, 'store'])->name('store');
        Route::get('/index', [App\Http\Controllers\Adjustment\AdjustmentController::class, 'index'])->name('index');
        Route::get('/show/{adjustment}', [App\Http\Controllers\Adjustment\AdjustmentController::class, 'show'])->name('show');
    });
});
