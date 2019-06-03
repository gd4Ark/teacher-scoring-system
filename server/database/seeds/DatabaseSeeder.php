<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {

        $calls = [
            AdminsTableSeeder::class,
        ];

        if (env('APP_ENV') !== 'production') {
            $calls = array_merge($calls,[
                GroupsTableSeeder::class,
                SubjectsTableSeeder::class,
                TeachersTableSeeder::class,
                TeachingsTableSeeder::class,
                StudentsTableSeeder::class,
                ScoresTableSeeder::class,
            ]);
        }

        $this->call($calls);
   }
}