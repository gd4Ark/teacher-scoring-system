<?php

use App\Models\Score;
use App\Models\Group;

use Illuminate\Database\Seeder;

class ScoresTableSeeder extends Seeder
{
    public function run()
    {
        $groups = Group::all();
        Score::query()->truncate();
        foreach ($groups as $group) {
            $teachings = $group->teachings;
            $students = $group->students;
            foreach ($teachings as $teaching) {
                $result = [];

                foreach ($students as $student) {
                    $base = [
                        'student_id' => $student->id,
                        'group_id' => $group->id,
                        'subject_id' => $teaching->subject_id,
                        'teacher_id' => $teaching->teacher_id
                    ];

                    $projects = [
                        '教学能力' => array_random([2, 4, 6]) + array_random([2, 5, 7]),
                        '教学水平' => array_random([1, 3]) + array_random([1, 3, 5]) + array_random([1, 2]),
                        '教学效果' => array_random([1, 2, 3, 4]) + array_random([1, 2, 3, 4]) + array_random([1, 3, 4]),
                    ];
                    $total = 0;
                    foreach ($projects as $project) {
                        $total += (int)$project;
                    }
                    $projects['total'] = $total;

                    $suggest = $student->name . ' 留的的建议';

                    $scores = array_merge($base, [
                        'meta' => json_encode([
                            'score' => [
                                'project' => $projects,
                                'suggest' => $suggest,
                            ]
                        ])
                    ]);

                    $result[] = $scores;
                }

                Score::query()->insert($result);
            }
        }
    }
}
