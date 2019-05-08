<?php
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
use App\Models\Score;
use App\Models\User;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{

    public function run()
    {
        User::query()->truncate();
        User::query()->create([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT)
        ]);
        if (env('APP_ENV') !== 'production') {
//            Group::query()->delete();
//            factory(Group::class, 1)->create();
//            Student::query()->delete();
//            factory(Student::class, 1)->create();
//            Subject::query()->delete();
//            factory(Subject::class, 1)->create();
//            Teacher::query()->delete();
//            factory(Teacher::class, 1)->create();
//            Teaching::query()->delete();
//            factory(Teaching::class, 1)->create();

            /**
             * group
             */
            $group_names = [
                '16春计网专（1）',
                '17春计网专（2）',
                '18春计网专（3）',
                '16春会计专（1）',
                '17春会计专（2）',
                '18春会计专（3）',
                '16春电商专（1）',
                '17春电商专（2）',
                '18春电商专（3）',
            ];
            $groups = [];
            foreach ($group_names as $group_name){
                array_push($groups,[
                    'name' => $group_name
                ]);
            }
            Group::query()->delete();
            Group::query()->insert($groups);

            /**
             * subject
             */
            $subject_names = [
                '计算机维修',
                '网络管理',
                '数据库',
                'C语言',
                '前端开发',
                '后端开发',
                '云计算基础',
                'VB语言',
                '综合布线',
                'PhotoShop',
                'Flash动画制作',
                '计算机英语',
                '电子电工基础',
                '应用文',
                '新模式英语',
            ];
            $subjects = [];
            foreach ($subject_names as $subject_name){
                array_push($subjects,[
                    'name' => $subject_name
                ]);
            }
            Subject::query()->delete();
            Subject::query()->insert($subjects);

            /**
             * teachers
             */
            $teacher_names = [
                '田川暮',
                '郭昱文',
                '田春岚',
                '金嫔然',
                '崔博雅',
                '彭学英',
                '夏夏柳',
                '宋孤云',
                '金朝雨',
                '邱彦露',
                '方知睿',
                '金婀娜',
                '余冬寒',
                '张凉音',
                '邓婷丽',
            ];
            $teachers = [];

            foreach ($teacher_names as $teacher_name){
                array_push($teachers,[
                    'name' => $teacher_name
                ]);
            }
            Teacher::query()->delete();
            Teacher::query()->insert($teachers);
        }

        /**
         * students
         */
        Student::query()->delete();
        $groups = Group::all();
        foreach ($groups as $group){
            $student_count = random_int(20,40);
            $student_name = $group->name . '测试学生';
            $students = [];
            for ($i = 0; $i < $student_count; $i++){
                array_push($students, [
                    'group_id' => $group->id,
                    'name' => $student_name . $i,
                    'complete' => array_random([0,1]),
                ]);
            }
            Student::query()->insert($students);
        }

        /**
         * teachings
         */
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

        /**
         * scores
         */
        Score::query()->truncate();
        foreach ($groups as $group){
            $teachings = $group->teachings;
            $students = $group->students;
            foreach ($teachings as $teaching ){

                $score_list = [];

                foreach ($students as $student){

                    $base = [
                        'student_id' => $student->id,
                        'group_id' => $group->id,
                        'subject_id' => $teaching->subject_id,
                        'teacher_id' => $teaching->teacher_id
                    ];

                    $projects = [
                        '教学能力' => array_random([2,4,6]) + array_random([2,5,7]),
                        '教学水平' => array_random([1,3]) + array_random([1,3,5]) + array_random([1,2]),
                        '教学效果' => array_random([1,2,3,4]) + array_random([1,2,3,4]) + array_random([1,3,4]),
                    ];
                    $total = 0;
                    foreach ($projects as $project){
                        $total += (int)$project;
                    }
                    $projects['total'] = $total;

                    $suggest = $student->name . ' 留的的建议';

                    $scores = array_merge($base,[
                        'meta' => json_encode([
                            'score' => [
                                'project' => $projects,
                                'suggest' => $suggest,
                            ]
                        ])
                    ]);

                    array_push($score_list,$scores);
                }

                Score::query()->insert($score_list);
            }
        }
   }
}