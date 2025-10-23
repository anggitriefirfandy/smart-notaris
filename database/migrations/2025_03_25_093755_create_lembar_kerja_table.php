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
        Schema::create('lembar_kerja', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->uuid('notaris_id')->nullable();
            $table->uuid('bank_id')->nullable();
            $table->string('nama');
            $table->string('detail_pekerjaan');
            $table->string('status_diterima')->nullable();
            $table->string('status_dikerjakan')->nullable();
            $table->string('status_selesai')->nullable();
            $table->string('status')->nullable();
            $table->string('file')->nullable();
            $table->dateTime('waktu_proses')->nullable();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembar_kerja');
    }
};
