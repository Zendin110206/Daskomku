<!-- routes/web.php -->

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
use App\Http\Controllers\Auth\AdminProfileController;
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
    // Halaman home-nya CAAS
    Route::view('home', 'CaAs.HomePageCaAs')->name('caas.home');

    // Logout CAAS
    Route::post('logout', [CaasSessionController::class, 'destroy'])->name('caas.logout');

    // Ganti password CAAS
    Route::view('change-password', 'CaAs.ChangePassword')->name('caas.change-password');

    // Profile CAAS
    Route::view('profile', 'CaAs.ProfileCaAs')->name('caas.profile');

    // Pengumuman
    Route::view('announcement', 'CaAs.Announcement')->name('caas.announcement');

    Route::post('shift/pick', [PlottinganController::class, 'pickShift'])
        ->name('caas.shift.pick');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [CaasSessionController::class, 'index'])->name('caas.login');
    Route::post('login', [CaasSessionController::class, 'store'])->name('caas.login.authenticate');
    Route::get('admin/login', [AdminSessionController::class, 'index'])->name('admin.login');
    Route::post('admin/login', [AdminSessionController::class, 'store'])->name('admin.login.authenticate');
});

Route::view('/admin', 'secret');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('asisten', UserAsistenController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names([
            'index' => 'asisten',       // GET /admin/asisten
            'store' => 'asisten.create', // POST /admin/asisten
            'update' => 'asisten.update', // PATCH or POST /admin/asisten/{id}
            'destroy' => 'asisten.delete', // DELETE /admin/asisten/{id}
        ]);

    // Tambah endpoint reset
    Route::post('/shift/reset-plot', [ShiftController::class, 'resetPlot'])->name('shift.resetPlot');
    Route::post('/shift/reset-shift', [ShiftController::class, 'resetShift'])->name('shift.resetShift');
    Route::view('home', 'admin.home')->name('home');
    // Route::view('reset-password', 'admin.reset-password')->name('reset-password');

    Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::post('/shift', [ShiftController::class, 'store'])->name('shift.store');
    Route::get('/shift/{id}', [ShiftController::class, 'show'])->name('shift.show');
    Route::put('/shift/{id}', [ShiftController::class, 'update'])->name('shift.update');
    Route::delete('/shift/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy');

    // Reset Shift & Plot
    Route::post('/shift/reset-shifts', [ShiftController::class, 'resetShifts'])->name('shift.resetShifts');
    Route::post('/shift/reset-plot', [ShiftController::class, 'resetPlot'])->name('shift.resetPlot');

    // Ini logout terpisah karena kalo pake Route::resource dia jadi DELETE /admin/login/{login}
    Route::post('logout', [AdminSessionController::class, 'destroy'])->name('logout');

    $resources = [
        'announcement' => AnnouncementController::class,
        'shift' => ShiftController::class,
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
                'store' => "$key.store",
                'destroy' => "$key.delete",
                'update' => "$key.update",
            ]);
    }

    Route::get('/view-plot', [PlottinganController::class, 'viewPlot'])->name('view-plot');
    Route::get('/view-plot/{id}', [PlottinganController::class, 'show'])->name('view-plot.show');

    // RESET PASSWORD ADMIN
    Route::get('/reset-password', [AdminProfileController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [AdminProfileController::class, 'updatePassword'])->name('reset-password.update');
});


Route::fallback(function () {
    return redirect()->route('caas.login');
});