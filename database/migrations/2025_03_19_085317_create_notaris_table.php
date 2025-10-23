<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notaris', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama');
            $table->integer('jenis_kelamin')->comment('1 laki_laki; 2 perempuan');

            $table->string('picture')->nullable();
            $table->string('nomor_notaris')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('telepon')->nullable();
            $table->string('fax')->nullable();
            $table->string('merchant_id')->nullable();
            $table->json('kontak')->nullable();
            $table->integer('lock')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('created_by_merchant')->nullable();
            $table->uuid('last_edited_by')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('uid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notaris');
    }
};
