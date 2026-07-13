<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('field_id')->constrained('fields')->cascadeOnDelete();
            $table->dateTime('start_time'); // Giờ bắt đầu đá
            $table->dateTime('end_time'); // Giờ kết thúc
            $table->decimal('total_price', 10, 2); // Tổng tiền dự kiến
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending'); // Trạng thái đơn
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
