<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('usuario', function (Blueprint $table) {
      $table->increments('intId');
      $table->unsignedInteger('intIdTipoUsuario');
      $table->string('strNome', 100);
      $table->string('strEmail', 100)->unique();
      $table->string('strDocumento', 14)->unique();
      $table->string('strSenha');
      $table->decimal('floatSaldo',8,2)->default(0);
      $table->timestamp('strDataCadastro')->nullable();
      $table->timestamp('strDataAtualizacao')->nullable();

      $table->foreign('intIdTipoUsuario')->references('intId')->on('tipo');

      $table->index(['floatSaldo']);
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
