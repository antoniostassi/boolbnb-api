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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title', 128);
            $table->tinyInteger('rooms')->unsigned();
            $table->tinyInteger('beds')->unsigned();
            $table->tinyInteger('bathrooms')->unsigned();
            $table->smallInteger('apartment_size')->unsigned();
            $table->json('address');
            $table->string('image', 1024);
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Schema::dropIfExists('apartments');
        });
    }
};
