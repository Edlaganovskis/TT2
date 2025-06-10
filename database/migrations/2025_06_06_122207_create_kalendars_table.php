<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void      // Datubāzes kolonnu izveide kalendaram
    {
        Schema::create('kalendars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('publisks')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalendars');
    }
};
