<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tipo', function (Blueprint $table) {
      $table->increments('intId');
      $table->unsignedInteger('intIdTipo')->nullable();
      $table->string('strNome');
      $table->string('strCor')->nullable();
      $table->string('strValor')->nullable();
      $table->tinyInteger('intOrdem')->default(1);

      $table->foreign('intIdTipo')->references('intId')->on('tipo');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
  }
}
