<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\FieldType;
use App\Models\Field;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo dữ liệu Vai trò (Roles)
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị viên hệ thống']);
        $customerRole = Role::firstOrCreate(['name' => 'customer'], ['description' => 'Khách hàng đặt sân']);

        // 2. Tạo tài khoản Admin mẫu
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'email_verified_at' => now(),
        ]);

        // 3. TẠO THÊM 2 TÀI KHOẢN KHÁCH HÀNG MẪU
        $customer1 = User::create([
            'name' => 'Trần Dương Luân',
            'email' => 'luan@gmail.com',
            'password' => Hash::make('password'), // Mật khẩu: password
            'role_id' => $customerRole->id,
            'email_verified_at' => now(),
        ]);

        $customer2 = User::create([
            'name' => 'Nguyễn Văn Hải',
            'email' => 'hai@gmail.com',
            'password' => Hash::make('password'), // Mật khẩu: password
            'role_id' => $customerRole->id,
            'email_verified_at' => now(),
        ]);

        // 4. Tạo Loại sân
        $type5 = FieldType::create(['name' => 'Sân 5 người', 'description' => 'Dành cho đội hình nhỏ']);
        $type7 = FieldType::create(['name' => 'Sân 7 người', 'description' => 'Dành cho đá phong trào']);

        // 5. Tạo Danh sách Sân bóng
        $fieldA1 = Field::create(['name' => 'Sân A1 (5 người)', 'field_type_id' => $type5->id, 'price_per_hour' => 150000]);
        $fieldA2 = Field::create(['name' => 'Sân A2 (5 người)', 'field_type_id' => $type5->id, 'price_per_hour' => 150000]);
        $fieldB1 = Field::create(['name' => 'Sân B1 (7 người)', 'field_type_id' => $type7->id, 'price_per_hour' => 300000]);
        $fieldVIP = Field::create(['name' => 'Sân VIP (7 người)', 'field_type_id' => $type7->id, 'price_per_hour' => 400000]);

        // 6. Tạo Dịch vụ đi kèm
        $water = Service::create(['name' => 'Nước suối Aquafina', 'price' => 10000]);
        $sting = Service::create(['name' => 'Bò húc / Nước tăng lực', 'price' => 15000]);
        $bib = Service::create(['name' => 'Thuê áo Bib (bộ)', 'price' => 30000]);
        $ball = Service::create(['name' => 'Thuê bóng đá', 'price' => 50000]);

        // ==========================================================
        // 7. TẠO DỮ LIỆU ĐƠN ĐẶT SÂN MẪU (BOOKINGS & PAYMENTS)
        // ==========================================================
        
        // Đơn 1: Khách hàng Luân đặt sân A1 hôm nay - Trạng thái: CHỜ DUYỆT (Pending)
        $booking1 = Booking::create([
            'user_id' => $customer1->id,
            'field_id' => $fieldA1->id,
            'start_time' => Carbon::today()->setHour(17)->setMinute(0), // 17:00 hôm nay
            'end_time' => Carbon::today()->setHour(18)->setMinute(30),   // 18:30 hôm nay (1.5 tiếng = 225k)
            'total_price' => 255000, // Tiền sân 225k + 2 chai nước (20k) + 1 bóng (10k tạm tính)
            'status' => 'pending'
        ]);
        $booking1->services()->attach([
            $water->id => ['quantity' => 2, 'price' => $water->price]
        ]);
        $booking1->payment()->create([
            'amount' => 255000,
            'payment_method' => 'cash',
            'payment_status' => 'pending'
        ]);

        // Đơn 2: Khách hàng Luân đặt sân B1 ngày mai - Trạng thái: ĐÃ XÁC NHẬN (Confirmed)
        $booking2 = Booking::create([
            'user_id' => $customer1->id,
            'field_id' => $fieldB1->id,
            'start_time' => Carbon::tomorrow()->setHour(19)->setMinute(0), // 19:00 ngày mai
            'end_time' => Carbon::tomorrow()->setHour(21)->setMinute(0),   // 21:00 ngày mai (2 tiếng = 600k)
            'total_price' => 630000, // Tiền sân 600k + Thuê áo Bib 30k
            'status' => 'confirmed'
        ]);
        $booking2->services()->attach([
            $bib->id => ['quantity' => 1, 'price' => $bib->price]
        ]);
        $booking2->payment()->create([
            'amount' => 630000,
            'payment_method' => 'cash',
            'payment_status' => 'pending'
        ]);

        // Đơn 3: Khách hàng Hải đặt sân VIP tuần trước - Trạng thái: HOÀN TẤT & ĐÃ THU TIỀN (Completed / Paid)
        $booking3 = Booking::create([
            'user_id' => $customer2->id,
            'field_id' => $fieldVIP->id,
            'start_time' => Carbon::now()->subDays(3)->setHour(18)->setMinute(0), // 3 ngày trước
            'end_time' => Carbon::now()->subDays(3)->setHour(19)->setMinute(30),  // Đá 1.5 tiếng = 600k
            'total_price' => 675000, // Tiền sân 600k + 5 bò húc (75k)
            'status' => 'completed'
        ]);
        $booking3->services()->attach([
            $sting->id => ['quantity' => 5, 'price' => $sting->price]
        ]);
        $booking3->payment()->create([
            'amount' => 675000,
            'payment_method' => 'cash',
            'payment_status' => 'paid' // Đơn này đã hoàn tất nên thanh toán thành công
        ]);

        // Đơn 4: Khách hàng Hải đặt sân A2 nhưng ĐÃ HỦY (Cancelled)
        $booking4 = Booking::create([
            'user_id' => $customer2->id,
            'field_id' => $fieldA2->id,
            'start_time' => Carbon::now()->subDays(5)->setHour(16)->setMinute(0),
            'end_time' => Carbon::now()->subDays(5)->setHour(17)->setMinute(0), // 1 tiếng = 150k
            'total_price' => 150000,
            'status' => 'cancelled'
        ]);
        $booking4->payment()->create([
            'amount' => 150000,
            'payment_method' => 'cash',
            'payment_status' => 'failed'
        ]);
    }
}