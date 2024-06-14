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
        Schema::create('semis_contestant', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contestantID');
            $table->unsignedInteger('rank');
            $table->unsignedInteger('eventID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semis_contestant');
    }
};
