<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;

// Static fast paths (avoid Laravel bootstrap for common browser probes)
Route::get('/.well-known/appspecific/com.chrome.devtools.json', function () {
	return response()->noContent(204)->header('Cache-Control', 'public, max-age=86400');
});

Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'application/xml');
})->name('sitemap');
Route::get('/availability', [ReservationController::class, 'availability'])->name('reservations.availability');
Route::get('/day-availability', [ReservationController::class, 'dayAvailability'])->name('reservations.dayAvailability');
Route::get('/month-availability', [ReservationController::class, 'monthAvailability'])->name('reservations.monthAvailability');
Route::get('/available-durations', [ReservationController::class, 'availableDurations'])->name('reservations.availableDurations');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/otkazi/{token}', [ReservationController::class, 'showCancel'])->name('reservations.cancel.show')->where('token', '[A-Za-z0-9]{64}');
Route::post('/otkazi/{token}', [ReservationController::class, 'cancel'])->name('reservations.cancel')->where('token', '[A-Za-z0-9]{64}');

Route::prefix('admin')->group(function (): void {
	Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login.show');
	Route::post('/login', [AdminController::class, 'login'])->name('admin.login');

	Route::middleware('auth')->group(function (): void {
		Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
		Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
		Route::post('/reservations/{reservation}/cancel', [AdminController::class, 'cancel'])
			->name('admin.reservations.cancel')
			->whereNumber('reservation');
		Route::post('/reservations/{reservation}/message', [AdminController::class, 'sendMessage'])
			->name('admin.reservations.message')
			->whereNumber('reservation');

		Route::get('/blokirani', [AdminController::class, 'blockedIndex'])->name('admin.blocked.index');
		Route::post('/blokirani', [AdminController::class, 'blockedStore'])->name('admin.blocked.store');
		Route::post('/blokirani/{blocked}/odblokiraj', [AdminController::class, 'unblock'])
			->name('admin.blocked.unblock')
			->whereNumber('blocked');

		Route::get('/tereni', [AdminController::class, 'courtsIndex'])->name('admin.courts.index');
		Route::post('/tereni/{court}/toggle', [AdminController::class, 'toggleCourt'])
			->name('admin.courts.toggle')
			->whereNumber('court');
	});
});
