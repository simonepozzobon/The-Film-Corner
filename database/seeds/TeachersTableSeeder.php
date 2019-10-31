<?php

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            [
                'status' => 1,
                'name' => 'Celi',
                'email' => 'monichetti@yahoo.it',
                'password' => Hash::make('uDkyhz'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Alessandrini',
                'email' => 'alessandrini.cristina@gmail.com',
                'password' => Hash::make('Go7sOu'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Bazzocchi',
                'email' => 'silvia.bazzocchi@gmail.com',
                'password' => Hash::make('DRE6tD'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Lo Cascio',
                'email' => 'eldalocascio@libero.it',
                'password' => Hash::make('TeDO7A'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Doriguzzi',
                'email' => 'beatrice.doriguzzibozzo@istruzione.it',
                'password' => Hash::make('MvV4Zx'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Restelli',
                'email' => 'patriziarestelli52@hotmail.com',
                'password' => Hash::make('q3syOi'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Carlucci',
                'email' => 'robertocarlucci1972@gmail.com',
                'password' => Hash::make('qhmqD1'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'De Meo',
                'email' => 'marinademeo2@gmail.com',
                'password' => Hash::make('6VDAdW'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Musolino',
                'email' => 'giov.mus@gmail.com',
                'password' => Hash::make('DYLNmB'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Arcangeletti',
                'email' => 'mariaelena.arcangeletti@itsosmilano.it',
                'password' => Hash::make('82UVdg'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Mattei',
                'email' => 'ilmatt@tiscali.it',
                'password' => Hash::make('nwKmNC'),
                'school_id' => 0,
                'students_slots' => 6,
            ],
            [
                'status' => 1,
                'name' => 'Cascina',
                'email' => 'progettocinema2d@gmail.com',
                'password' => Hash::make('NMiguE'),
                'school_id' => 0,
                'students_slots' => 6,
            ],

        ]);
    }
}
