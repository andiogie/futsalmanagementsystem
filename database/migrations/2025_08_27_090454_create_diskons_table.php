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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->string('nama_diskon');       // contoh: "Diskon Pelajar"
            $table->string('kode')->nullable();
            $table->enum('tipe', ['persentase', 'nominal'])->default('persentase');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->integer('nilai');           // bisa 10% atau 20000
            $table->date('mulai')->nullable();  // periode mulai
            $table->date('berakhir')->nullable(); // periode akhir
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};
