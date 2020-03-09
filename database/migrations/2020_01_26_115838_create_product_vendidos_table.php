<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVendidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_vendidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('venta_id');
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->integer('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->integer('cuenta_id')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->string('nombre')->nullable();
            $table->string('n_serie')->nullable();
            $table->string('color')->nullable();
            $table->string('talle')->nullable();
            $table->integer('costo');
            $table->integer('precio');
            $table->integer('cantidad');
            $table->integer('descuento')->nullable();
            $table->string('estado');
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
        Schema::dropIfExists('product_vendidos');
    }
}
