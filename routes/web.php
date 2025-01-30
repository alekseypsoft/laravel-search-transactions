<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::get('/', [TransactionController::class, 'search'])->name('dashboard');
    Route::get('/get-user-balance', [TransactionController::class, 'balance'])->name('balance');
});

Auth::routes();

