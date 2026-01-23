<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\EmiController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/loan-details', [LoanController::class, 'index'])->name('loan.details');
    Route::get('/emi-details', [EmiController::class, 'index'])->name('emi.index');
    Route::post('/process-data', [EmiController::class, 'process'])->name('emi.process');
    Route::view('/calculator', 'calculator')->name('calculator');
});
