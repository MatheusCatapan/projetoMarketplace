<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('users_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('addressId')->nullable();
            $table->dateTime('orderDate');
        
            $table->foreign('addressId')->references('user_id')->on('users_addresses')->onDelete('cascade');
        });
    }    
    
  
    public function down(): void
    {
        Schema::dropIfExists('users_orders');
    }
};
