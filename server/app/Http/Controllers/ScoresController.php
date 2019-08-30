<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScoresController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api', [
            'except' => ['index', 'detail']
        ]);
    }

    public function index(Request $request)
    {
        $query = Score::query()
            ->select('subject_id', 'teacher_id')
            ->selectRaw('COUNT(student_id) as student_count')
            ->selectRaw("ROUND(AVG(meta->'$.score.project.教学效果'),2) as 教学效果")
            ->selectRaw("ROUND(AVG(meta->'$.score.project.教学水平'),2) as 教学水平")
            ->selectRaw("ROUND(AVG(meta->'$.score.project.教学能力'),2) as 教学能力")
            ->selectRaw("ROUND(AVG(meta->'$.score.project.total'),2) as avg")
            ->groupBy(['subject_id', 'teacher_id']);

        $query = $this->queryFilter($query);

        return $this->paginateToJson($query);
    }

    public function detail($sid, $tid)
    {
        $query = Score::query()
            ->where('subject_id', $sid)
            ->where('teacher_id', $tid)
            ->select('subject_id', 'teacher_id', 'group_id')
            ->selectRaw("ROUND(meta->'$.score.project.教学效果',2) as 教学效果")
            ->selectRaw("ROUND(meta->'$.score.project.教学水平',2) as 教学水平")
            ->selectRaw("ROUND(meta->'$.score.project.教学能力',2) as 教学能力")
            ->selectRaw("ROUND(meta->'$.score.project.total',2) as total")
            ->selectRaw("JSON_UNQUOTE(meta->'$.score.suggest') as suggest")
            ->selectRaw("CHAR_LENGTH(JSON_UNQUOTE(meta->'$.score.suggest')) as suggest_len");

        $query = $this->queryFilter($query);

        $merge = [
            'subject' => Subject::query()->findOrFail($sid),
            'teacher' => Teacher::query()->findOrFail($tid),
        ];

        return $this->success(array_merge(
            $merge,
            $this->paginate($query)->toArray()
        ));
    }
}
