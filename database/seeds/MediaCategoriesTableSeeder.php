<?php

use Illuminate\Database\Seeder;

class MediaCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media_sub_categories')->truncate();
        DB::table('media_sub_categories')->insert([
            [
                'app_id' => 1,
                'name' => 'Landscapes'
            ],
            [
                'app_id' => 1,
                'name' => 'Objects'
            ],
            [
                'app_id' => 1,
                'name' => 'People'
            ],
            [
                'app_id' => 2,
                'name' => 'Scenario'
            ],
            [
                'app_id' => 3,
                'name' => 'Images'
            ],
            [
                'app_id' => 13,
                'name' => 'Landscapes'
            ],
            [
                'app_id' => 13,
                'name' => 'Objects'
            ],
            [
                'app_id' => 13,
                'name' => 'Clothes'
            ],
            [
                'app_id' => 13,
                'name' => 'Feelings'
            ],
            [
                'app_id' => 14,
                'name' => 'Library 1'
            ],
            [
                'app_id' => 14,
                'name' => 'Library 2'
            ],
            [
                'app_id' => 14,
                'name' => 'Library 3'
            ],
            [
                'app_id' => 14,
                'name' => 'Library 4'
            ],
        ]);

    }
}
