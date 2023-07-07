<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!W
|
*/


//login
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/loginAction', [AuthController::class, 'loginAction'])->name('login.action');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('registration')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('register');
    Route::post('/insert', [RegistrationController::class, 'add'])->name('register.action');
});
Route::middleware('auth', 'auth')->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::post('/add', [ProductController::class, 'create'])->name('product.add');
        Route::post('/getData', [ProductController::class, 'getData'])->name('product.data');
        Route::post('/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/delete', [ProductController::class, 'destroy'])->name('product.delete');
    });
});