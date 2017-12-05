<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(CitiesTableSeeder::class);
        // $this->call(PointsTableSeeder::class);
        // $this->call(AppSectionsTableSeeder::class);
        // $this->call(AppCategoriesTableSeeder::class);
        // $this->call(AppKeywordsTableSeeder::class);
        // $this->call(AppTableSeeder::class);
        // $this->call(AppLanguages::class);
        $this->call(TeachersTableSeeder::class);
    }
}
