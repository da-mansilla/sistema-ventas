<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cuenta_id')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');
            $table->integer('venta_id')->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->integer('pagado');
            $table->text('descripcion')->nullable();
            $table->integer('batch');
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
        Schema::dropIfExists('pagos');
    }
}
