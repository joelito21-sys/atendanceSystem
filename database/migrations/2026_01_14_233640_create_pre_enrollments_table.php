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
        Schema::create('pre_enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('student_id_number');
            $table->string('subject_code');
            $table->string('section')->nullable();
            $table->string('school_year');
            $table->enum('semester', ['1st', '2nd', 'full_year'])->default('full_year');
            $table->timestamps();

            $table->index('student_id_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_enrollments');
    }
};
