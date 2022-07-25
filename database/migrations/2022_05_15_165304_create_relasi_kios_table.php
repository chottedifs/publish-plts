<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelasiKiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relasi_kios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kios_id')->constrained();
            $table->foreignId('lokasi_id')->constrained();
            $table->foreignId('tarif_kios_id')->constrained();
            $table->boolean('use_plts');
            $table->boolean('status_relasi_kios');
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
        Schema::dropIfExists('relasi_kios');
    }
}
