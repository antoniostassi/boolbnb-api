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
        Schema::create('apartment_promotion', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('apartment_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Schema::dropIfExists('apartment_promotion');
        });
    }
};
