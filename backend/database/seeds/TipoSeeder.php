<?php

use App\Helpers\Utilidade;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TipoRepositoryIntercace;

class TipoSeeder extends DatabaseSeeder
{
  private $repro;

  public function __construct(TipoRepositoryIntercace $repro)
  {
    $this->repro = $repro;
  }
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $json = database_path('seeds/resource/tipo_table.json');

    if (!file_exists($json)) return;

    $results = json_decode(file_get_contents($json), true);

    $this->startProgress(count($results));

    foreach ($results as $result) {
      $this->repro->cadastrarTipo($result);
      $this->advanceProgress();
    }

    $this->endProgress();
  }
}
