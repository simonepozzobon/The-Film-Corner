<?php

use Illuminate\Database\Seeder;

class AppSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('app_sections')->truncate();
      DB::table('app_sections')->insert([
        [
          'name' => 'Film Specific',
          'slug' => 'film-specific'
        ],
        [
          'name' => 'Creative Studio',
          'slug' => 'creative-studio'
        ],
        [
          'name' => 'Cinema',
          'slug' => 'cinema'
        ]
      ]);
    }
}
