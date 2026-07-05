<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isEmployee()) {
        return redirect()->route('employee.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->name('home');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/fields', [AdminController::class, 'fields'])->name('admin.fields');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    
    Route::resource('fields', FieldController::class)->except(['index', 'show'])->names([
        'create' => 'admin.fields.create',
        'store' => 'admin.fields.store',
        'edit' => 'admin.fields.edit',
        'update' => 'admin.fields.update',
        'destroy' => 'admin.fields.destroy',
    ]);
});

// Employee Routes
Route::middleware(['auth', 'role:employee,admin'])->prefix('employee')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/bookings', [EmployeeController::class, 'bookings'])->name('employee.bookings');
    Route::post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('employee.bookings.status');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/bookings', [CustomerController::class, 'myBookings'])->name('customer.bookings');
    Route::get('/fields/{field}', [CustomerController::class, 'showField'])->name('customer.fields.show');
    Route::get('/bookings/checkout/{field}', [BookingController::class, 'checkout'])->name('customer.bookings.checkout');
    Route::post('/bookings', [BookingController::class, 'store'])->name('customer.bookings.store');
});

// Admin & Employee can both update booking status
Route::middleware(['auth', 'role:admin,employee'])->post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
