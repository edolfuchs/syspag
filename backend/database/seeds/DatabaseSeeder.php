<?php
use App\Helpers\Utilidade;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{ 

  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  { 
    $this->call(TipoSeeder::class);
  }

  public function startProgress($lines = 0)
  {
    $this->command->getOutput()->progressStart($lines);
  }

  public function advanceProgress()
  {
    $this->command->getOutput()->progressAdvance();
  }

  public function endProgress()
  {
    $this->command->getOutput()->progressFinish();
  }
}
