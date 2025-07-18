<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->integer('stock');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
        });
}

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
