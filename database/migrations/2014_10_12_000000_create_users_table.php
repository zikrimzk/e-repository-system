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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('matricNo');
            $table->string('password');
            $table->string('phoneNo');
            $table->string('gender');
            $table->string('role');
            $table->string('status');
            $table->string('address')->nullable();     
            $table->string('bio')->nullable();
            $table->integer('semcount')->default(1);
            $table->foreignId('semester_id');
            $table->foreignId('programme_id');
            $table->integer('opcode')->default(1);
            $table->string('titleOfResearch')->nullable();     
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
