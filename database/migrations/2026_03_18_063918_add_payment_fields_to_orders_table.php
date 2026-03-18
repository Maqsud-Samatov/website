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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('commission', 10, 2)->default(0)->after('total');
            $table->decimal('restaurant_amount', 10, 2)->default(0)->after('commission');
            $table->string('click_transaction_id')->nullable()->after('payment_status');
            $table->string('payme_transaction_id')->nullable()->after('click_transaction_id');
            $table->timestamp('paid_at')->nullable()->after('payme_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
