<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('cities')->truncate();
      DB::table('cities')->insert([
        [
          'name' => 'Milan',
          'center-lat' => '45.464167',
          'center-long' => '9.190027',
        ],
        [
          'name' => 'Canterbury',
          'center-lat' => '51.280367',
          'center-long' => '1.078958',
        ],
        [
          'name' => 'Belgrado',
          'center-lat' => '44.814503',
          'center-long' => '20.421735',
        ],
        [
          'name' => 'Londonderry',
          'center-lat' => '54.996739',
          'center-long' => '-7.308581',
        ]
      ]);
    }
}
