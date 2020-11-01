<?php

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


Auth::routes();

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user/{id}', [App\Http\Controllers\LicenseController::class, 'get_user'])->name('get_user');
Route::get('/license', [App\Http\Controllers\LicenseController::class, 'index'])->name('license');
Route::get('/license/activate', [App\Http\Controllers\LicenseController::class, 'activate'])->name('license.activate');
Route::post('/license', [App\Http\Controllers\LicenseController::class, 'store'])->name('license.store');
Route::get('/key_gen/{id}/{duration}', [App\Http\Controllers\LicenseController::class, 'key_gen'])->name('key_gen');

