<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('no_pegawai')->nullable();
            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->boolean('status')->default(true);
            $table->string('foto')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('jabatan_id');
            $table->unsignedInteger('user_id')->nullable();
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
        Schema::dropIfExists('staffs');
        // $table->dropForeign(['user_id']);
    }
}
