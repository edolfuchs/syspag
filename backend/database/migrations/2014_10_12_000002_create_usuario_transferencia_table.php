<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTransferenciaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('usuario_transferencia', function (Blueprint $table) {
      $table->increments('intId');
      $table->unsignedInteger('intIdTipoStatusTransferencia');
      $table->unsignedInteger('intIdTipoStatusNotificacao');
      $table->unsignedInteger('intIdUsuarioPagador');
      $table->unsignedInteger('intIdUsuarioBeneficiario');
      $table->decimal('floatValor',8,2);
      $table->string('strObservacao',1000)->nullable();
      $table->timestamp('strDataNotificacao')->nullable();
      $table->timestamp('strDataCadastro')->nullable();
      $table->timestamp('strDataAtualizacao')->nullable();

      $table->foreign('intIdUsuarioPagador')->references('intId')->on('usuario');
      $table->foreign('intIdUsuarioBeneficiario')->references('intId')->on('usuario');
      $table->foreign('intIdTipoStatusTransferencia')->references('intId')->on('tipo');
      $table->foreign('intIdTipoStatusNotificacao')->references('intId')->on('tipo');

      $table->index(['floatValor','strDataNotificacao']);
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
