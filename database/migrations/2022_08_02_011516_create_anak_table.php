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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('nik_ortu');
            $table->string('nama_ibu');
            $table->string('nama_ayah');
            $table->integer('jk');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('golda');
            $table->integer('anak');
            $table->integer('id_kec');
            $table->integer('id_kel');
            $table->integer('rt');
            $table->integer('rw');
            $table->text('catatan');
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
        Schema::dropIfExists('balita');
    }
};
