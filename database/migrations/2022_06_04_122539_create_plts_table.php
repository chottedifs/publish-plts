<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePltsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->foreignId('login_id')->constrained();
            $table->foreignId('lokasi_id')->constrained();
            $table->string('nip');
            $table->string('no_hp');
            $table->string('jenis_kelamin');
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
        Schema::dropIfExists('plts');
    }
}
