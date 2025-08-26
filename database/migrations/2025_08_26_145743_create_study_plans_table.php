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
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_class_id')->constrained('course_classes')->cascadeOnDelete();
            $table->string('semester_label', 10); // 2025-1
            $table->string('status')->default('draft'); // draft|submitted|approved|rejected
            $table->timestamps();
            $table->unique(['student_id','course_class_id','semester_label']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_plans');
    }
};
