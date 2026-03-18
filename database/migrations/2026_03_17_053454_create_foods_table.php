<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('ingredients')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('prep_time')->default(15);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('foods');
    }
};