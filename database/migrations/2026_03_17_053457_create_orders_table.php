<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'on_the_way',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->enum('payment_method', ['cash', 'click', 'payme', 'card'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('address');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};