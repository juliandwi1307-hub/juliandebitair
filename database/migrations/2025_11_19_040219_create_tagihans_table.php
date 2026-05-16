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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();

            // Kolom FK yang benar
            $table->foreignId('pengguna_id')
                ->constrained('pengguna')
                ->onDelete('cascade');

            $table->string('bulan');
            $table->year('tahun');
            $table->integer('awal');
            $table->integer('akhir');
            $table->integer('jumlah');
            $table->decimal('tarif', 8, 2);
            $table->decimal('tagihan', 10, 2);
            $table->enum('status', ['lunas', 'belum lunas'])->default('belum lunas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
