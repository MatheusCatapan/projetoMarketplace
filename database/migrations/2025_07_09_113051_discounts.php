<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('startDate');
            $table->date('endDate');
            $table->decimal('discount', 5, 2);
        });
}

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
