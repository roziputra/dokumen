<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('satker_penilaian_id');
            $table->foreign('satker_penilaian_id')->references('id')->on('satker_penilaians');
            $table->unsignedBigInteger('grup_penilaian');
            $table->unsignedBigInteger('sub_grup_penilaian');
            $table->string('judul_penilaian');
            $table->string('kelengkapan')->nullable();
            $table->string('tingkat_kelengkapan')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('penilaians');
    }
}
