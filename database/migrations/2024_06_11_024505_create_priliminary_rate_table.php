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
        Schema::create('priliminary_rate', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contestantID');
            $table->unsignedInteger('poise');
            $table->unsignedInteger('projection');
            $table->unsignedInteger('eventID');
            $table->string('judgesCode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priliminary_rate');
    }
};
