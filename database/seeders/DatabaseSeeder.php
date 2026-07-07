<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Employee User
        User::create([
            'name' => 'Nhân Viên',
            'email' => 'employee@example.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
        ]);

        // Create Customer User
        User::create([
            'name' => 'Khách Hàng',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        // Create Football Fields
        Field::create([
            'name' => 'Sân Bóng A1',
            'type' => '5 người',
            'description' => 'Sân cỏ nhân tạo chất lượng cao, phù hợp cho các trận đấu 5 người.',
            'price_per_hour' => 300000,
            'is_active' => true,
        ]);

        Field::create([
            'name' => 'Sân Bóng A2',
            'type' => '5 người',
            'description' => 'Sân cỏ tự nhiên, hoàn hảo cho các buổi tập luyện và thi đấu.',
            'price_per_hour' => 350000,
            'is_active' => true,
        ]);

        Field::create([
            'name' => 'Sân Bóng B1',
            'type' => '7 người',
            'description' => 'Sân lớn, phù hợp cho các trận đấu 7 người chuyên nghiệp.',
            'price_per_hour' => 500000,
            'is_active' => true,
        ]);

        Field::create([
            'name' => 'Sân Bóng C1',
            'type' => '11 người',
            'description' => 'Sân bóng đá theo tiêu chuẩn quốc tế, diện tích đầy đủ.',
            'price_per_hour' => 800000,
            'is_active' => true,
        ]);
    }
}
