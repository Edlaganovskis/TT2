<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void  // Datubāzes kolonnu izveide Garastavoklim
    {
        Schema::create('garastavoklis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('datums');
            $table->string('Gstavoklis');
            $table->text('sajutas')->nullable();
            $table->text('iemesls')->nullable();
            $table->text('piezimes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kalendars_id')->constrained('kalendars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garastavoklis');
    }
};
