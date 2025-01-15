<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AdminSessionController;
use App\Http\Controllers\Auth\CaasSessionController;
use App\Http\Controllers\UserAsistenController;
use App\Http\Controllers\UserCaasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlottinganController;
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

Route::middleware(['auth', 'caas'])->group(function () {
    Route::post('logout', [CaasSessionController::class, 'destroy'])->name('caas.logout');
    Route::view('home', 'CaAs.HomePageCaAs')->name('caas.home');
    Route::view('change-password', 'CaAs.ChangePassword')->name('caas.change-password');
    Route::view('profile', 'CaAs.ProfileCaAs')->name('caas.profile');
    Route::view('announcement', 'CaAs.Announcement')->name('caas.announcement');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [CaasSessionController::class, 'index'])->name('caas.login');
    Route::post('login', [CaasSessionController::class, 'store'])->name('caas.login.authenticate');
    Route::get('admin/login', [AdminSessionController::class, 'index'])->name('admin.login');
    Route::post('admin/login', [AdminSessionController::class, 'store'])->name('admin.login.authenticate');
});

Route::view('/admin', 'secret');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('home', 'admin.home')->name('home');
    Route::view('reset-password', 'admin.reset-password')->name('reset-password');

    // Ini logout terpisah karena kalo pake Route::resource dia jadi DELETE /admin/login/{login}
    Route::post('logout', [AdminSessionController::class, 'destroy'])->name('logout');

    $resources = [
        'announcement' => AnnouncementController::class,
        'shift' => ShiftController::class,
        'view-plot' => PlottinganController::class,
        'asisten' => UserAsistenController::class,
        'caas' => UserCaasController::class,
        'gems' => RoleController::class,
        'stage' => StageController::class,
        'dashboard' => DashboardController::class,
    ];

    foreach ($resources as $key => $controller) {
        Route::resource($key, $controller)
            ->only(['index', 'store', 'destroy', 'update'])
            ->names([
                'index' => "$key",
                'store' => "$key.create",
                'destroy' => "$key.delete",
                'update' => "$key.update",
            ]);
    }
});

Route::fallback(function () {
    return redirect()->route('caas.login');
});