<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tagihan');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sewa_kios_id')->constrained();
            $table->foreignId('lokasi_id')->constrained();
            $table->float('total_kwh');
            $table->integer('diskon');
            $table->text('remarks')->nullable();
            $table->integer('tagihan_kwh');
            $table->integer('tagihan_kios');
            $table->date('periode');
            $table->foreignId('master_status_id')->constrained();
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
        Schema::dropIfExists('tagihans');
    }
}
