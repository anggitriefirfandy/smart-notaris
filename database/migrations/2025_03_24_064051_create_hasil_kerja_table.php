<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_kerja', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->uuid('lembar_id')->nullable();
            $table->uuid('notaris_id')->nullable();
            $table->uuid('bank_id')->nullable();
            $table->string('dokumen');
            $table->integer('status');
            $table->integer('status_doc');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_kerja');
    }
};
