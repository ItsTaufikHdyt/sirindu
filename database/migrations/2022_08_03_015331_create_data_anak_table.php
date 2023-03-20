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
        Schema::create('data_anak', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_anak')->unsigned();
            $table->date('tgl_kunjungan');
            $table->integer('bln');
            $table->string('posisi');
            $table->float('tb');
            $table->float('bb');
            $table->float('lla');
            $table->float('lk');
            $table->string('ntob')->nullable();
            $table->string('asi')->nullable();
            $table->string('vit_a')->nullable();
            $table->string('obat_cacing')->nullable();
            $table->string('ddtka')->nullable();
            $table->integer('id_user');
            $table->timestamps();
            $table->foreign('id_anak')
                  ->references('id')->on('anak')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_anak');
    }
};
