<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 1500);
            $table->string('nama');
            $table->string('jk', 1);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('alamat', 500);
            $table->string('kel', 100);
            $table->string('kec', 100);
            $table->string('kota', 100);
            $table->boolean('status')->default(true);
            $table->string('rw', 3)->nullable();
            $table->string('rt', 3)->nullable();
            $table->string('agama')->nullable();
            $table->string('kawin')->nullable();
            $table->foreignId('kerja_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wargas');
    }
}
