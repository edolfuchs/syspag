<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioExtratoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('usuario_extrato', function (Blueprint $table) {
      $table->increments('intId');
      $table->unsignedInteger('intIdTipoLancamento');
      $table->unsignedInteger('intIdUsuario');
      $table->unsignedInteger('intIdUsuarioLancamento')->nullable();
      $table->decimal('floatValor',8,2);
      $table->string('strObservacao')->nullable();
      $table->timestamp('strDataCadastro')->nullable();
      $table->timestamp('strDataAtualizacao')->nullable();

      $table->foreign('intIdUsuario')->references('intId')->on('usuario');
      $table->foreign('intIdUsuarioLancamento')->references('intId')->on('usuario');
      $table->foreign('intIdTipoLancamento')->references('intId')->on('tipo');
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
