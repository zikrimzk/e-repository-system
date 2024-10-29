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
        Schema::create('activity_programmes', function (Blueprint $table) {
            $table->foreignId('activities_id')->constrained('activities');
            $table->foreignId('programmes_id')->constrained('programmes');
            $table->integer('act_seq');
            $table->integer('timeline_sem');
            $table->integer('timeline_week');
            $table->string('init_status');
            $table->integer('is_haveEva')->default(0);
            $table->string('meterial')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_programmes');
    }
};
