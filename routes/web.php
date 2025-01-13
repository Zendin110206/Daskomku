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

Route::get('/', function () {
    return view('CaAs.LoginCaAs');
});
Route::get('/CaAs', function () {
    return view('CaAs.HomePageCaAs');
});
Route::get('/Profile', function () {
    return view('CaAs.ProfileCaAs');
});
Route::get('/ChangePassword', function () {
    return view('CaAs.ChangePassword');
});
Route::get('/Announcement', function () {
    return view('CaAs.Announcement');
});
Route::get('/Assistants', function () {
    return view('CaAs.AssistantsPage');
});
Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});

Route::get('/login', function () {
    return view('CaAs.loginCaas');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('home', function () {
        return view('admin.home');
    })->name('home'); // namanya jadi admin.home karena method prefix()
    
    Route::get('reset-password', function () {
        return view('admin.reset-password');
    })->name('reset-password'); // jadi admin.reset-password

    Route::resource('login', AdminSessionController::class)->only(['index', 'store'])->names([
        'index' => 'login', // jadi admin.login, ini halaman login di /admin/login
        'store' => 'login.authenticate', // jadi admin.login.authenticate
    ]);
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

Route::name('caas.')->group(function () {
    Route::get('home', function () {
        return view('CaAs.HomePageCaAs');
    })->name('home');
    
    Route::get('reset-password', function () {
        return view('CaAs.ChangePassword');
    })->name('reset-password');

    Route::resource('login', CaasSessionController::class)->only(['index', 'store'])->names([
        'index' => 'login',
        'store' => 'login.authenticate',
    ]);

    Route::post('logout', [CaasSessionController::class, 'destroy'])->name('logout');
});