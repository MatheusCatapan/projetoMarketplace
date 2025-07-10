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
            $table->foreignId('addressId')->constrained('users_addresses')->onDelete('cascade');
            $table->dateTime('orderDate');

            $table->foreignId('couponId')->constrained('coupons_orders')->onDelete('cascade');
            $table->decimal('totalPrice', 10, 2);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users_orders');
    }
};
