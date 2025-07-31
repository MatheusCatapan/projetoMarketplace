<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->decimal('discount', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {

    }
};
