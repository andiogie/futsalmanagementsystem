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
        Schema::create('mst_rekening', function (Blueprint $table) {
            $table->id();
            $table->string('bank_account'); // nomor rekening / no e-wallet
            $table->string('bank_name');    // nama bank / provider e-wallet
            $table->string('account_name'); // nama pemilik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_rekening');
    }
};
