<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRate;



Route::get('/', [ExchangeRate::class, 'index']);
Route::get('/exchange-rate',[ExchangeRate::class, 'exchange_rate'])->name('exchange_rate');
// conversion
Route::get('/conversion/{firstCurrency}/{secondCurrency}/{value}',[ExchangeRate::class, 'conversion'])->name('conversion');
// Route::get('/offline',[ExchangeRate::class, 'offline']);

Route::get('/test', [ExchangeRate::class, 'test']);
