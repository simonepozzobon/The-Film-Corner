<?php

use Illuminate\Database\Seeder;

class AppCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('app_categories')->truncate();
      DB::table('app_categories')->insert([
        [
          'name' => 'Framing',
          'slug' => 'framing',
          'app_section_id' => 1
        ],
        [
          'name' => 'Editing',
          'slug' => 'editing',
          'app_section_id' => 1
        ],
        [
          'name' => 'Sound',
          'slug' => 'sound',
          'app_section_id' => 1
        ],
        [
          'name' => 'Characters',
          'slug' => 'characters',
          'app_section_id' => 1
        ],
        [
          'name' => 'Warm Up',
          'slug' => 'warm-up',
          'app_section_id' => 2
        ],
        [
          'name' => 'Story Telling',
          'slug' => 'story-telling',
          'app_section_id' => 2
        ],
        [
          'name' => 'MyCorner Contest',
          'slug' => 'mycorner-contest',
          'app_section_id' => 2
        ],
      ]);
    }
}
