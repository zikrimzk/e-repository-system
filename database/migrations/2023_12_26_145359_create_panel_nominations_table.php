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
        Schema::create('panel_nominations', function (Blueprint $table) {
            $table->id();
            $table->string('nom_status');
            $table->string('nom_document')->nullable();
            $table->string('nom_date')->nullable();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('activity_id')->constrained('activities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panel_nominations');
    }
};
