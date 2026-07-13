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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Sân số 1, Sân số 2...
            $table->foreignId('field_type_id')->constrained('field_types')->cascadeOnDelete();
            $table->decimal('price_per_hour', 10, 2); // Giá thuê mỗi giờ
            $table->boolean('is_active')->default(true); // Trạng thái sân có đang mở không
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
