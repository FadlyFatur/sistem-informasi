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
            $table->string('id_pegawai', 20);
            $table->foreignId('user_id')->nullable();
            $table->foreignId('jabatan_id')->nullable();
            $table->string('nama', 100);
            $table->string('no_hp', 14)->nullable();
            $table->string('alamat', 200)->nullable();
            $table->boolean('status')->default(true);
            $table->string('foto')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('staffs');
        // $table->dropForeign(['user_id']);
    }
}
