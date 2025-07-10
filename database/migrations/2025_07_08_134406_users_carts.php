<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_carts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->useCurrent();

            $table->foreignId('user_id',)->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_carts');
    }
};
