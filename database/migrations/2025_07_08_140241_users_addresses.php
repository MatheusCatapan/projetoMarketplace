<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('users_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('street')->nullable();
            $table->integer('number', 4)->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
}
    
    public function down(): void
    {
        Schema::dropIfExists('users_addresses');
    }
};
