<?php

use App\Http\Controllers\CaasController;
use App\Http\Controllers\CaasStageController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\PlottinganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('CaAs.loginCaas');
});

// Route untuk halaman login admin
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/admin/home', function () {
    return view('admin.home');
})->name('admin.home');

Route::get('/admin/reset-password', function () {
    return view('admin.reset-password');
})->name('admin.reset-password');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/announcement', function () {
    return view('admin.announcement');
})->name('admin.announcement');

Route::get('/admin/caas', function () {
    return view('admin.caas');
})->name('admin.caas');

Route::get('/admin/shift', function () {
    return view('admin.shift');
})->name('admin.shift');

Route::get('/admin/view-plot', function () {
    return view('admin.view-plot');
})->name('admin.view-plot');

Route::get('/admin/gems', function () {
    return view('admin.gems');
})->name('admin.gems');

Route::prefix('admin')->group(function () {
    Route::resource('caas', CaasController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('shifts', ShiftController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('schedule-plots', PlottinganController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('caas-stage', CaasStageController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('configuration', ConfigurationController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('gems', RoleController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('stage', StageController::class)->only(['index', 'store', 'edit', 'update']);
});
