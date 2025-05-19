<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ExtendStayController;
use App\Http\Controllers\ReceptionistController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/book', [RoomController::class, 'bookingForm'])->name('rooms.book');
Route::post('/rooms/{room}/book', [RoomController::class, 'processBooking'])
    ->middleware('auth')
    ->name('rooms.process-booking');

// Commented out the original /dashboard route
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer routes
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/service-request', [ServiceRequestController::class, 'index'])->name('customer.service-request');
    Route::post('/service-request', [ServiceRequestController::class, 'store'])->name('customer.service-request.store');
    Route::get('/extend-stay', [ExtendStayController::class, 'index'])->name('customer.extend-stay');
    Route::post('/extend-stay', [ExtendStayController::class, 'store'])->name('customer.extend-stay.store');
    Route::get('/book-room/{room}', [RoomController::class, 'bookingForm'])->name('customer.book-room');
    Route::post('/book-room/{room}', [RoomController::class, 'processBooking'])->name('customer.book-room.store');
    Route::get('/bookings/{booking}/confirmation', [RoomController::class, 'confirmation'])->name('bookings.confirmation');
    Route::post('/bookings/{booking}/cancel', [CustomerController::class, 'cancelBooking'])->name('customer.booking.cancel');
    Route::get('/bookings/cancel/payment', [CustomerController::class, 'showCancellationPayment'])->name('customer.booking.cancel.payment');
    Route::post('/bookings/cancel/payment/process', [CustomerController::class, 'processCancellationPayment'])->name('customer.booking.cancel.payment.process');
    Route::get('/bookings/{booking}/receipt', [CustomerController::class, 'showReceipt'])->name('customer.booking.receipt');

    // Admin routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/receptionist', [AdminController::class, 'receptionist'])->name('admin.receptionist');
    Route::get('/admin/services', [AdminController::class, 'services'])->name('admin.services');

    // Receptionist Routes
    Route::prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
        Route::get('/checkin', [ReceptionistController::class, 'checkin'])->name('checkin');
        Route::post('/checkin/process', [ReceptionistController::class, 'processCheckin'])->name('process-checkin');
        Route::post('/checkout/process', [ReceptionistController::class, 'processCheckout'])->name('process-checkout');
        Route::get('/checkout', [ReceptionistController::class, 'checkout'])->name('checkout');
        Route::get('/rooms', [ReceptionistController::class, 'rooms'])->name('rooms');
        Route::post('/rooms/{id}/update-status', [ReceptionistController::class, 'updateRoomStatus'])->name('rooms.update-status');
        Route::get('/bookings/create', [ReceptionistController::class, 'createBooking'])->name('bookings.create');
        Route::get('/bookings/{id}', [ReceptionistController::class, 'viewBooking'])->name('bookings.view');
        Route::post('/bookings/{id}/approve', [ReceptionistController::class, 'approveBooking'])->name('bookings.approve');
        Route::post('/bookings/{id}/reject', [ReceptionistController::class, 'rejectBooking'])->name('bookings.reject');
        Route::get('/bookings/{id}/payment', [ReceptionistController::class, 'showPayment'])->name('bookings.payment');
        Route::post('/bookings/{id}/payment', [ReceptionistController::class, 'processPayment'])->name('bookings.process-payment');
    });
});

Route::post('/admin/rooms/store', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
Route::put('/admin/rooms/update', [AdminController::class, 'updateRoom'])->name('admin.rooms.update');
Route::post('/admin/categories/store', [AdminController::class, 'storeCategory'])->name('admin.categories.store');

Route::post('/admin/employees/store', [AdminController::class, 'storeEmployee'])->name('admin.employees.store');
Route::put('/admin/employees/update', [AdminController::class, 'updateEmployee'])->name('admin.employees.update');
Route::put('/admin/employees/activate', [AdminController::class, 'activateEmployee'])->name('admin.employees.activate');
Route::put('/admin/employees/deactivate', [AdminController::class, 'deactivateEmployee'])->name('admin.employees.deactivate');

Route::get('/admin/transactions/{id}/print', [AdminController::class, 'printTransaction'])->name('admin.transactions.print');
Route::get('/admin/transactions/export/{type}', [AdminController::class, 'exportTransactions'])->name('admin.transactions.export');

Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::put('/admin/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::post('/admin/users/reset-password', [AdminController::class, 'resetUserPassword'])->name('admin.users.reset-password');
Route::put('/admin/users/activate', [AdminController::class, 'activateUser'])->name('admin.users.activate');
Route::put('/admin/users/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');

require __DIR__.'/auth.php';