<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PartnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                [
                    'name' => 'john',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'john@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'eavan',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'eavan@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'ian',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'ian@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'bane',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'bane@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'aleksandar',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'aleksandar@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'tea',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'tea@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'kote',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'kote@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'emanuela',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'emanuela@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'tanja',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'tanja@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'ana',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'ana@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'silvia',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'silvia@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'simone',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'simone@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'sofia',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'sofia@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
                [
                    'name' => 'francesco',
                    'surname' => '',
                    'role_id' => 1,
                    'email' => 'francesco@thefilmcorner.dev',
                    'password' => Hash::make('tfc_dev2019'),
                    'old_id' => 0,
                ],
        ]);
    }
}
