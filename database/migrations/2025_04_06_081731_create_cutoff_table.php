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
        Schema::create('cutoff', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->nullable();
            $table->uuid('notaris_id')->nullable();
            $table->uuid('bank_id')->nullable();
            $table->string('nama')->nullable();
            $table->text('detail_pekerjaan')->nullable();
            $table->integer('status')->nullable();
            $table->integer('status_diterima')->nullable();
            $table->integer('status_dikerjakan')->nullable();
            $table->integer('status_selesai')->nullable();
            $table->integer('status_tolak_notaris')->nullable();
            $table->double('fee')->nullable();
            $table->string('file')->nullable();
            $table->timestamp('waktu_proses')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutoff');
    }
};
