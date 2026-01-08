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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('invoice_no')->unique()->nullable();
            $table->string('whatsapp');
            $table->date('tanggal');
            $table->unsignedBigInteger('lapangan_id');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('durasi'); // dalam jam
            $table->decimal('tarif'); // dalam rupiah
            $table->enum('payment_type', ['Cash', 'QRIS', 'Transfer'])->nullable();
            $table->enum('payment_status', ['Pending', 'Paid', 'Cancel'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
