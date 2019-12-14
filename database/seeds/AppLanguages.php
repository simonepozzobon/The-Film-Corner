<?php

use Illuminate\Database\Seeder;

class AppLanguages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('languages')->truncate();
      DB::table('languages')->insert([
        [
          'language' => 'English',
          'short' => 'en',
        ],
        [
          'language' => 'Francais',
          'short' => 'fr',
        ],
        [
          'language' => 'Italiano',
          'short' => 'it',
        ],
        [
          'language' => 'Serbian',
          'short' => 'sr',
        ],

      ]);
    }
}
