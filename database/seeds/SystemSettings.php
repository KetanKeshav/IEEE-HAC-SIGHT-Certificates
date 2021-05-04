<?php

use Illuminate\Database\Seeder;

class SystemSettings extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('system_settings')->insert([
      'meta_key' => 'generate_bulk_certificate',
      'value' => '0',
    ]);
  }
}
