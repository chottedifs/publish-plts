<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSewaKiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sewa_kios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('relasi_kios_id')->constrained();
            $table->foreignId('lokasi_id')->constrained();
            $table->date('tgl_sewa');
            $table->date('tgl_akhir_sewa')->nullable(true);
            $table->boolean('status_sewa');
            $table->boolean('use_plts');
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
        Schema::dropIfExists('sewa_kios');
    }
}
