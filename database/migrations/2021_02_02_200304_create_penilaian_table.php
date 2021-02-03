<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianTable extends Migration
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
            $table->string('tahun');
            $table->string('karyawan');
            $table->integer('kedisiplinan');
            $table->integer('loyalitas');
            $table->integer('tanggungjawab');
            $table->integer('kualitas');
            $table->integer('kecepatan');
            $table->integer('inisiatif');
            $table->integer('mengatur');
            $table->integer('kerjasama');
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
