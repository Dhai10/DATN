<?php
use App\Models\Field;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FieldController; 
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminFieldController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminServiceController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    // Lấy 3 sân bóng đang hoạt động để làm nổi bật trên trang chủ
    $featuredFields = Field::with('fieldType')
        ->where('is_active', true)
        ->inRandomOrder() // Lấy ngẫu nhiên cho trang chủ thêm sinh động
        ->take(3)
        ->get();
        
    return view('welcome', compact('featuredFields'));
});

// Sửa lại route dashboard để gọi hàm index trong FieldController
Route::get('/dashboard', [FieldController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chức năng Đặt sân (Dành cho mọi user đã đăng nhập)
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/my-bookings/{id}/pdf', [BookingController::class, 'downloadPDF'])->name('bookings.pdf');
    Route::patch('/my-bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Xem chi tiết sân bóng
    Route::get('/fields/{id}', [FieldController::class, 'show'])->name('fields.show');
    // API lấy dữ liệu Lịch của sân
    Route::get('/fields/{id}/bookings-json', [FieldController::class, 'getBookings'])->name('fields.bookings.json');
    
    Route::get('/fields/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/fields/{id}/book', [BookingController::class, 'store'])->name('bookings.store');
    
    
    // ==========================================
    // KHU VỰC DÀNH RIÊNG CHO ADMIN (CÓ LỚP BẢO VỆ)
    // ==========================================
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Quản lý Đặt sân
        Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
        Route::patch('/admin/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.update_status');
        
        // Quản lý Sân bóng
        Route::resource('admin/fields', AdminFieldController::class)->except(['show'])->names([
            'index'   => 'admin.fields.index',
            'create'  => 'admin.fields.create',
            'store'   => 'admin.fields.store',
            'edit'    => 'admin.fields.edit',
            'update'  => 'admin.fields.update',
            'destroy' => 'admin.fields.destroy',
        ]);
        // Quản lý Dịch vụ
        Route::resource('admin/services', AdminServiceController::class)->except(['show'])->names([
            'index'   => 'admin.services.index',
            'create'  => 'admin.services.create',
            'store'   => 'admin.services.store',
            'edit'    => 'admin.services.edit',
            'update'  => 'admin.services.update',
            'destroy' => 'admin.services.destroy',
        ]);
        
        // Quản lý Khách hàng
        Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/admin/customers/{id}/edit', [AdminCustomerController::class, 'edit'])->name('admin.customers.edit');
        Route::put('/admin/customers/{id}', [AdminCustomerController::class, 'update'])->name('admin.customers.update');
        
        // Quản lý Giao dịch
        Route::get('/admin/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
        Route::patch('/admin/payments/{id}/status', [AdminPaymentController::class, 'updateStatus'])->name('admin.payments.update_status');
    });
});
    
    

require __DIR__.'/auth.php';