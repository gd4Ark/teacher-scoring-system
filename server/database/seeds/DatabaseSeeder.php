<?php

use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate();
        User::query()->create([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT)
        ]);
        if (env('APP_ENV') !== 'production') {
            Group::query()->delete();
            factory(Group::class, 30)->create();
            Student::query()->delete();
            factory(Student::class, 500)->create();
            Subject::query()->delete();
            factory(Subject::class, 30)->create();
            Teacher::query()->delete();
            factory(Teacher::class, 30)->create();
            Teaching::query()->delete();
            factory(Teaching::class, 80)->create();
        }
    }
}