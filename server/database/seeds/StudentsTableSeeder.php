<?php

use App\Models\Student;
use App\Models\Group;

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        Student::query()->delete();
        $groups = Group::all();
        foreach ($groups as $group) {
            $student_count = random_int(20, 40);
            $student_name = $group->name . '测试学生';
            $result = [];
            for ($i = 0; $i < $student_count; $i++) {
                $result[] = [
                    'group_id' => $group->id,
                    'name' => $student_name . $i,
                    'complete' => array_random([0, 1]),
                ];
            }
            Student::query()->insert($result);
        }
    }
}
