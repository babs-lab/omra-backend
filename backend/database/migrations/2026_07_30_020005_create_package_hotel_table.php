<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_hotel', function (Blueprint $table) {
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('nights');
            $table->primary(['package_id', 'hotel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_hotel');
    }
};
