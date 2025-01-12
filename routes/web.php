<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AdminSessionController;
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

//maaf, aku gak nyadar kalau udah ada, gak nydar jadi route ku masih dibawah, minta tolong sesuiakan ya, sorry2
// aman bro, skrg cuma 27 line doang buat backend ini. di bawah ini ada 27 route dari admin.auth (get), admin.auth.login (post), admin.auth.logout (delete), admin.caas.create (post), admin.caas (get), admin.caas.update (put/patch)... php artisan route:list
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('home', function () {
        return view('admin.home');
    })->name('home');
    
    Route::get('reset-password', function () {
        return view('admin.reset-password');
    })->name('reset-password');

    Route::resource('auth', AdminSessionController::class)->only(['index', 'store'])->names([
        'index' => 'auth',
        'store' => 'auth.login',
    ]);

    Route::post('auth/logout', [AdminSessionController::class, 'destroy'])->name('auth.logout');

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