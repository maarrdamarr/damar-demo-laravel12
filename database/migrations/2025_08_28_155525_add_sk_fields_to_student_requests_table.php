<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('student_requests', function (Blueprint $t) {
            $t->string('decision_number')->nullable()->unique()->after('note'); // No SK
            $t->date('decision_date')->nullable()->after('decision_number');   // Tgl SK
            $t->string('effective_semester', 10)->nullable()->after('decision_date'); // ex: 2025-1
            $t->date('effective_date')->nullable()->after('effective_semester');     // ex: 2025-08-01
            // penanda penandatangan (opsional, bisa pakai processed_by)
            // $t->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('student_requests', function (Blueprint $t) {
            $t->dropColumn(['decision_number','decision_date','effective_semester','effective_date']);
        });
    }
};
