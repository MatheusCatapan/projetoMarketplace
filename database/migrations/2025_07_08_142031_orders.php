<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //STATUS: ENUM('PENDING', 'PROCESSING','SHIPPED','COMPLETED','CANCELLED')
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('address_id')->constrained('users_addresses')->onDelete('cascade');
            $table->dateTime('order_date');
            $table->enum('status', ['PENDING', 'PROCESSING', 'SHIPPED', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->foreignId('couponId')->nullable()->constrained('coupons')->onDelete('cascade');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users_orders');
    }
};
