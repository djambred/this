<?php

use App\Http\Controllers\BatchRegisterController;
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
Route::get('/register/batch/{batch}', ShowRegisterPage::class)->name('register.batch.show');
Route::post('/register/batch/{batch}/pay', [BatchRegisterController::class, 'pay'])->name('register.batch.pay');
Route::post('/register/batch/midtrans-callback', [BatchRegisterController::class, 'midtransCallback']);
