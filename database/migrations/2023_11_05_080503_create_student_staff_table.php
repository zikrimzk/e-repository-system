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
        Schema::create('student_staff', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('staff_id')->constrained('staff');
            $table->string('supervision_role')->nullable();


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_staff');
    }
};
