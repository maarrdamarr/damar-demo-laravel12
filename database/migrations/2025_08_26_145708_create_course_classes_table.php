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
        Schema::create('course_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('class_code', 10); // A, B, C
            $table->foreignId('lecturer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedSmallInteger('quota')->default(30);
            $table->string('room')->nullable();
            $table->string('day')->nullable();   // Senin
            $table->string('time')->nullable();  // 08:00-09:40
            $table->timestamps();
            $table->unique(['course_id', 'class_code']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_classes');
    }
};
