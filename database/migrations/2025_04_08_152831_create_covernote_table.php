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
        Schema::create('covernote', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->uuid('lembar_id')->nullable();
            $table->uuid('notaris_id')->nullable();
            $table->uuid('bank_id')->nullable();
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('covernote');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('covernote');
    }
};
