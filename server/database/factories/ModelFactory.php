<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use App\Group;
use App\Teacher;
use App\Subject;
use App\Student;
use App\Teaching;
use Carbon\Carbon;

$factory->define(Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
        'allow' => rand(0,1),
    ];
});

$factory->define(Teacher::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});

$factory->define(Subject::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});

$factory->define(Student::class, function (Faker\Generator $faker) {
    $group = Group::query()->inRandomOrder()->first();
    return [
        'name' => $faker->word,
        'group_id' => $group['id'],
        'complete' => rand(0,1),
    ];
});

$factory->define(Teaching::class, function (Faker\Generator $faker) {
    $group = Group::query()->inRandomOrder()->first();
    $teacher = Teacher::query()->inRandomOrder()->first();
    $subject = Subject::query()->inRandomOrder()->first();
    return [
        'group_id' => $group['id'],
        'teacher_id' => $teacher['id'],
        'subject_id' => $subject['id'],
    ];
});