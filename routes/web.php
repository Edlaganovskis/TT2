<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GarastavoklisController;
use App\Http\Controllers\KalendarsController;
use App\Http\Controllers\WelcomeController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/publiskiekalendari', [KalendarsController::class, 'index']); // Publiskiem kalendāriem
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); //Kalendara skatam
    Route::get('/Garastavoklis/pievienot',[GarastavoklisController::class, 'create'])->name('Garastavoklis.pievienot'); // Ieraksta pievienošanai
    Route::post('/Garastavoklis',[GarastavoklisController::class, 'store'])->name('Garastavoklis.Registrs'); //Apstrādā formu
    Route::get('/Garastavoklis/{garastavoklis}/Rediget',[GarastavoklisController::class, 'rediget'])->name('Garastavoklis.Rediget'); //Ieraksta rediģēšana
    Route::put('/Garastavoklis/{garastavoklis}', [GarastavoklisController::class, 'atjaunot'])->name('Garastavoklis.atjaunot'); // Atjaunot ierakstu
    Route::post('/Garastavoklis/{garastavoklis}/dzest', [GarastavoklisController::class, 'dzest'])->name('Garastavoklis.dzest'); // Dzēst ierakstu
    Route::patch('/kalendars/{kalendars}/publisks', [KalendarsController::class, 'Publisks'])->name('kalendars.Publisks'); //Publisks/privāts kalendārs
    Route::delete('/kalendars/{kalendars}/dzest', [KalendarsController::class, 'destroy']); // kalendāra džešanai
    Route::get('/', [WelcomeController::class, 'index']); // Pēdēja Garastāvokļa ieteikumam.
});

require __DIR__.'/auth.php';
