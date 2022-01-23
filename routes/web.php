<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteController;
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

Route::get('/', [SiteController::class, 'index']);

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

Route::post('/webhook', [SiteController::class, 'webhook']);
