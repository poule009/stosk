<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelephoneController;
use App\Http\Controllers\VentesController;
use App\Http\Controllers\VendeurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController; // Add this line

Route::get('/', function () {
    return redirect()->route('telephones.index');
});

Route::get('telephones/names', [TelephoneController::class, 'names'])->name('telephones.names');
Route::get('telephones/models', [TelephoneController::class, 'models'])->name('telephones.models');
Route::resource('telephones', TelephoneController::class);
Route::resource('ventes', VentesController::class);
Route::resource('vendeurs', VendeurController::class);
Route::resource('clients', ClientController::class); 
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
