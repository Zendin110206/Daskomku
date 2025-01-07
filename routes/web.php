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

Route::get('/admin', function () {
    return view('admin.login');
});

Route::prefix('admin')->group(function () {
    Route::resource('caas', CaasController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('shifts', ShiftController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('schedule-plots', PlottinganController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('caas-stage', CaasStageController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('configuration', ConfigurationController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('gems', RoleController::class)->only(['index', 'store', 'edit', 'update']);
    Route::resource('stage', StageController::class)->only(['index', 'store', 'edit', 'update']);
});