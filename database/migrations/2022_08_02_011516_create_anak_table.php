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
            $table->uuid('id',32)->primary();
            $table->string('no_kk',16);
            $table->string('nik',16)->unique();
            $table->string('nama');
            $table->string('nik_ortu',16);
            $table->string('nama_ibu');
            $table->string('nama_ayah');
            $table->integer('jk');
            $table->string('tempat_lahir');
            $table->text('alamat');
            $table->date('tgl_lahir');
            $table->string('golda');
            $table->integer('anak')->nullable();
            $table->string('no')->nullable();
            $table->integer('status');
            $table->bigInteger('id_kec');
            $table->bigInteger('id_kel');
            $table->integer('id_rt')->nullable();
            $table->integer('id_posyandu')->nullable();
            $table->integer('id_puskesmas');
            $table->text('catatan');
            //imunisasi
            $table->integer('hbo')->nullable();
            $table->integer('bcg')->nullable();
            $table->integer('polio1')->nullable();
            $table->integer('dpthb_hib1')->nullable();
            $table->integer('polio2')->nullable();
            $table->integer('dpthb_hib2')->nullable();
            $table->integer('polio3')->nullable();
            $table->integer('dpthb_hib3')->nullable();
            $table->integer('polio4')->nullable();
            $table->integer('campak')->nullable();
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
