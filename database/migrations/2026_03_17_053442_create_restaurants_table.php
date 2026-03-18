<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->default('Toshkent');
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->integer('delivery_time')->default(30);
            $table->decimal('min_order', 8, 2)->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('restaurants');
    }
};