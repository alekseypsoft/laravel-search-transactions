<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [TransactionController::class, 'search'])->name('dashboard');
});

Auth::routes();

