<?php

use App\Models\Teaching;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;


use Illuminate\Database\Seeder;

class TeachingsTableSeeder extends Seeder
{
    public function run()
    {
        $groups = Group::all();
        foreach ($groups as $group){
            $teaching_count = random_int(4,6);
            for ($i = 0; $i < $teaching_count; $i++){
                $subject = Subject::query()->inRandomOrder()->first();
                $teacher = Teacher::query()->inRandomOrder()->first();
                $base = [
                    'subject_id' => $subject->id,
                    'group_id' => $group->id,
                ];
                Teaching::query()->firstOrCreate($base,array_merge($base,[
                    'teacher_id' => $teacher->id,
                ]));
            }
        }
    }
}
