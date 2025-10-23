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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->uuid('lembar_id')->nullable();
            $table->uuid('notaris_id')->nullable();
            $table->uuid('bank_id')->nullable();
            $table->string('nama_proses')->nullable();
            $table->uuid('created_by')->nullable();
            $table->date('tanggal_aktivitas')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
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
