<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('student_requests')) {
            Schema::create('student_requests', function (Blueprint $t) {
                $t->id();
                $t->foreignId('student_id')->constrained('users')->cascadeOnDelete();
                $t->string('type'); // cuti | pengunduran | dispensasi | lainnya
                $t->text('reason')->nullable();
                $t->string('status')->default('submitted'); // submitted|approved|rejected
                $t->json('extra')->nullable(); // semester, lampiran, dll
                $t->timestamp('submitted_at')->nullable();
                $t->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
                $t->timestamp('processed_at')->nullable();
                $t->string('note')->nullable();
                $t->timestamps();
                $t->index(['student_id','type','status']);
            });
        }
    }
    public function down(): void { Schema::dropIfExists('student_requests'); }
};
