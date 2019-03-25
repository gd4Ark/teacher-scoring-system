<?php
use App\Group;
use App\Student;
use App\Subject;
use App\Teacher;
use App\Teaching;
use App\User;
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
            'password' => password_hash('spider', PASSWORD_DEFAULT)
        ]);
        if (env('APP_ENV') !== 'production') {
            Group::query()->truncate();
            factory(Group::class, 20)->create();
            Student::query()->truncate();
            factory(Student::class, 20)->create();
            Subject::query()->truncate();
            factory(Subject::class, 20)->create();
            Teacher::query()->truncate();
            factory(Teacher::class, 20)->create();
            Teaching::query()->truncate();
            factory(Teaching::class, 20)->create();
        }
    }
}