<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clients');
            $table->string('forma_pago');
            $table->integer('pagoEfectivo');
            $table->integer('pagoTarjeta');
            $table->integer('total');
            $table->integer('seña')->nullable();
            $table->integer('deuda')->nullable();
            $table->string('promocion')->nullable();
            $table->integer('recargo')->nullable();
            $table->string('estado');
            $table->integer('enabled');
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
        Schema::dropIfExists('ventas');
    }
}
