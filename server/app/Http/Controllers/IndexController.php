<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;

class IndexController extends Controller
{

    public function index()
    {
        return $this->success([
            'count' => [
                'student_count' => Student::query()->count(),
                'group_count' => Group::query()->count(),
                'teacher_count' => Teacher::query()->count(),
                'subject_count' => Subject::query()->count(),
            ],
            'complete_info' => [
                'student' => $this->getStudentComplete(),
                'group' => $this->getGroupComplete(),
                'scores' => $this->getScoreComplete(),
            ]
        ]);
    }

    /**
     * @return array
     */
    private function getGroupComplete()
    {
        $query = Group::query()->select('id');
        $res = Group::getRelationCount($query)->get();
        return [
            [
                'state' => '未完成',
                'count' => $res->filter(function ($item) {
                    return $item->students_count !== $item->complete_count;
                })->count()
            ],
            [
                'state' => '已完成',
                'count' => $res->filter(function ($item) {
                    return $item->students_count === $item->complete_count;
                })->count()
            ],
        ];
    }

    /**
     * @return array
     */
    private function getStudentComplete()
    {
        return [
            [
                'state' => '未完成',
                'count' => Student::query()->whereComplete(0)->count(),
            ],
            [
                'state' => '已完成',
                'count' => Student::query()->whereComplete(1)->count(),
            ],
        ];
    }

    /**
     * @return array
     */
    private function getScoreComplete()
    {
        return Score::query()->distinct('student_id')
            ->selectRaw('count(student_id) as count')
            ->selectRaw('Date(created_at) as date')
            ->groupBy('date')
            ->get()
            ->toArray();
    }


    public function options()
    {
        $models = $this->req->get('models');
        $where = $this->req->get('where', []);
        if (empty($models)) {
            return [];
        }
        $res = [];
        foreach ($models as $model) {
            $label = 'name';
            $model_class = $this->getModel($model);
            $query = $model_class->where($where);
            $method_exists = method_exists($model_class, 'getOptions');

            $res[$model] = $method_exists
                ? $model_class->getOptions($query, $label)
                : $this->getOptions($query, $label);
        }
        return $res;
    }

    /**
     * @param string $model
     * @return mixed
     */
    protected function getModel(string $model)
    {
        $models = [
            'groups' => function () {
                return new Group();
            },
            'students' => function () {
                return new Student();
            },
            'subjects' => function () {
                return new Subject();
            },
            'teachers' => function () {
                return new Teacher();
            },
            'teachings' => function () {
                return new Teaching();
            }
        ];
        return $models[$model]();
    }
}
