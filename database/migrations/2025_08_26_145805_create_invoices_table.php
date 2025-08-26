<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat hanya jika tabel belum ada
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();

                // Mahasiswa pembayar
                $table->foreignId('student_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                // Nomor invoice unik
                $table->string('number')->unique();

                // Nominal (pakai integer tanpa pecahan; jika perlu desimal, ganti ke decimal(15,2))
                $table->unsignedBigInteger('amount');

                $table->date('due_date')->nullable();

                // unpaid | paid | expired | canceled (pakai string supaya fleksibel)
                $table->string('status')->default('unpaid')->index();

                // Waktu pembayaran jika sudah lunas
                $table->timestamp('paid_at')->nullable()->index();

                // Catatan opsional
                $table->string('note')->nullable();

                $table->timestamps();

                // Index tambahan untuk query cepat
                $table->index(['student_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
