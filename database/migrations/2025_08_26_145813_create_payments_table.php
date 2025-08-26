<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();

                // Relasi ke invoice
                $table->foreignId('invoice_id')
                    ->constrained('invoices')
                    ->cascadeOnDelete();

                // Pengaju/pembayar (umumnya mahasiswa)
                $table->foreignId('paid_by')
                    ->constrained('users')
                    ->cascadeOnDelete();

                // Verifikator (role keuangan), boleh kosong dulu
                $table->foreignId('verified_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                // Nominal dibayar (boleh split payment; kalau 1 invoice = 1 payment saja, tambahkan unique di invoice_id)
                $table->unsignedBigInteger('amount');

                // Referensi transaksi dari gateway/kasir (unik jika ada)
                $table->string('reference')->nullable()->unique();

                // Metode/kanal pembayaran (VA, transfer, kasir, e-wallet, dsb)
                $table->string('method')->nullable();
                $table->string('channel')->nullable();

                // pending | succeeded | failed | refunded
                $table->string('status')->default('pending')->index();

                // Bukti pembayaran opsional (URL/Path)
                $table->string('proof_url')->nullable();

                // Waktu dibayar & waktu verifikasi
                $table->timestamp('paid_at')->nullable()->index();
                $table->timestamp('verified_at')->nullable()->index();

                $table->timestamps();

                // Index yang sering dipakai
                $table->index(['invoice_id', 'status']);
                $table->index(['paid_by', 'paid_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
