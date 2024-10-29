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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('submission_doc')->nullable();
            $table->dateTime('submission_date')->nullable();
            $table->dateTime('submission_duedate');
            $table->string('submission_status')->default('No Attempt');
            $table->string('submission_final_form')->nullable();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('document_id')->constrained('documents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
