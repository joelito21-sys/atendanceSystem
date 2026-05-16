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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['quiz', 'oral', 'written', 'project', 'exam', 'assignment', 'participation']);
            $table->string('title');
            $table->decimal('score', 8, 2);
            $table->decimal('total_score', 8, 2);
            $table->enum('grading_period', ['1st', '2nd', '3rd', '4th'])->default('1st');
            $table->date('date_given');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
