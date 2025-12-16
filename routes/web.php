<?php

use Illuminate\Support\Facades\DB;

Route::get('/debug-db', function () {
    return [
        'database' => DB::connection()->getDatabaseName(),
        'host' => config('database.connections.mysql.host'),
        'port' => config('database.connections.mysql.port'),
        'user' => config('database.connections.mysql.username'),
        'sections_count' => \App\Models\Section::count(),
    ];
});

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationsController;

Route::redirect('/Reservations', '/reservations', 301);

Route::get('/', function () {
    return view('firstpage');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reservations', [ReservationsController::class, 'index'])->name('reservations.index')->middleware('auth');

    Route::get(
        '/reservations/create/{section}',
        [ReservationsController::class, 'create']
    )->name('reservations.create');

    Route::post('/reservations/{section}',
        [ReservationsController::class, 'store']
    )->name('reservations.store');

    Route::get('/my-bookings', [ReservationsController::class, 'myBookings'])
    ->middleware('auth')
    ->name('my-bookings');

    Route::get('/reservations/{reservation}/calendar', [ReservationsController::class, 'addToCalendar'])
    ->middleware('auth')
    ->name('reservations.calendar');

    Route::get(
        '/reservations/{reservation}',
        [ReservationsController::class, 'show']
    )->middleware('auth')->name('reservations.show');

    Route::post('/reservations/{reservation}/cancel', [ReservationsController::class, 'cancel'])
        ->middleware('auth')
        ->name('reservations.cancel');

});

use App\Http\Controllers\Admin\AdminReservationController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/reservations', [AdminReservationController::class, 'index'])
        ->name('admin.reservations');
    
    Route::post('/reservations/{reservation}/approve', [AdminReservationController::class, 'approve'])
        ->name('admin.reservations.approve');

    Route::post('/reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])
        ->name('admin.reservations.reject');
    
    Route::post(
        '/admin/reservations/{reservation}/{status}',
        [AdminReservationController::class, 'update']
    )->name('admin.reservations.update');

    Route::get('/admin/reservations', [AdminReservationController::class, 'index'])
        ->name('admin.reservations.index');

    Route::post('/admin/reservations/{reservation}/{status}', 
        [AdminReservationController::class, 'update']
    )->name('admin.reservations.update');
});



require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reservations', [AdminReservationController::class, 'index'])
        ->name('reservations.index');

    Route::patch('/reservations/{reservation}', [AdminReservationController::class, 'updateStatus'])
        ->name('reservations.update-status');
});

Route::view('/home', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('home');
