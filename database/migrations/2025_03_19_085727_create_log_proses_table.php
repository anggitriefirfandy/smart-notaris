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
        Schema::create('log_proses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->unsignedBigInteger('notaris_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('nama');
            $table->date('tanggal_mulai');
            $table->string('status');
            $table->dateTime('waktu_proses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_proses');
    }
};
