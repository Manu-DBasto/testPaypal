<?php

use App\Http\Controllers\PaypalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/messages', [PaypalController::class, 'index'])->name('messages.index');
Route::post('/messages', [PaypalController::class, 'store'])->name('messages.store');

Route::post('/webhooks/paypal', [PaypalController::class, 'handleRefound']);
