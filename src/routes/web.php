<?php

use App\Http\Controllers\MidtransController;
use App\Livewire\ShowHomePage;
use App\Livewire\ShowRegisterPage;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
Route::get('/', ShowHomePage::class )->name('home');

Route::get('/register/{productId}', ShowRegisterPage::class)->name('register');
Route::post('/midtrans/check-email', [\App\Http\Controllers\MidtransController::class, 'checkEmail'])->name('midtrans.check-email');
Route::post('/midtrans/snap-token', [\App\Http\Controllers\MidtransController::class, 'getSnapToken'])->name('midtrans.snap-token');
Route::post('/midtrans/store-result', [App\Http\Controllers\MidtransController::class, 'storeResult'])->name('midtrans.store-result');;
