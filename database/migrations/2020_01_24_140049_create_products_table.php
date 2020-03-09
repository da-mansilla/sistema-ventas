<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->integer('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->string('marca')->nullable();
            $table->integer('costo');
            $table->integer('precio');
            $table->string('color')->nullable();
            $table->string('talle')->nullable();
            $table->string('n_serie');
            $table->string('estado');
            $table->integer('enabled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
