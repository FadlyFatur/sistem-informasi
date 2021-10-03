<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berandas', function (Blueprint $table) {
            $table->id();
            $table->string('kontak', 200)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('alamat', 500)->nullable();
            $table->string('nama_intansi', 150)->nullable();
            // $table->string('kordinat')->nullable();
            $table->string('misi', 2000)->nullable();
            $table->string('visi', 1000)->nullable();
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berandas');
    }
}
