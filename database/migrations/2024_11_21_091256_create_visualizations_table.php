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
        Schema::create('visualizations', function (Blueprint $table) {
            $table->id();
            $table->foreignKey('apartment_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('ip_address', 24);
            $table->timestamps(); // Table "visit_date" is linked to timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Schema::dropIfExists('visualizations');
        });
    }
};
