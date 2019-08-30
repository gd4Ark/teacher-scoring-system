<?php

namespace App\Http\Controllers;

use App\Http\Requests\Archive\ArchiveCreateRequest;
use App\Http\Requests\Archive\ArchiveUpdateRequest;
use App\Models\Group;
use App\Models\Score;
use App\Models\Archive;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api', [
            'except' => ['index', 'show']
        ]);
    }

    public function index(Request $request)
    {
        $query = Archive::query();
        $query = $this->queryFilter($query);
        $query = $query->select(['id', 'name', 'created_at']);
        return $this->paginateToJson($query);
    }

    public function show($id)
    {
        $item = Archive::query()->findOrFail($id);
        return $this->success($item);
    }

    public function create(ArchiveCreateRequest $request)
    {
        $this->archive($request);

        $this->afterArchive();

        return $this->message('归档成功');
    }

    private function archive($request)
    {
        $query = Score::query()
            ->select(['teachers.name as teacher_name', 'subjects.name as subjects_name'])
            ->selectRaw('COUNT(scores.student_id) as student_count')
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.教学效果'),2) as 教学效果")
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.教学水平'),2) as 教学水平")
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.教学能力'),2) as 教学能力")
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.total'),2) as avg")
            ->leftJoin('teachers', 'scores.teacher_id', '=', 'teachers.id')
            ->leftJoin('subjects', 'scores.subject_id', '=', 'subjects.id')
            ->groupBy(['subject_id', 'teacher_id']);

        $archive = $query->get();

        Archive::query()->create([
            'name' => $request->get('name'),
            'meta' => [
                'archive' => $archive
            ]
        ]);
    }

    private function afterArchive()
    {
        Subject::query()->delete();
        Teacher::query()->delete();
        Group::query()->delete();
    }

    public function update(ArchiveUpdateRequest $request, $id)
    {
        $item = Archive::query()->findOrFail($id);
        $input = $request->all();
        $item->update($input);
        return $this->success($item);
    }
}
