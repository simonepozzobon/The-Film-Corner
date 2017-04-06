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
          'lat' => '45.464167',
          'lng' => '9.190027',
        ],
        [
          'name' => 'Canterbury',
          'lat' => '51.280367',
          'lng' => '1.078958',
        ],
        [
          'name' => 'Belgrado',
          'lat' => '44.814503',
          'lng' => '20.421735',
        ],
        [
          'name' => 'Londonderry',
          'lat' => '54.996739',
          'lng' => '-7.308581',
        ]
      ]);
    }
}
