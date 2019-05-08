<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Score;
use App\Models\Archive;
use App\Models\Subject;
use App\Models\Teacher;
use App\Rules\ArchiveRule;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show']
        ]);
    }

    public function index()
    {
        $query = Archive::query();
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            $query = $query->select(['id','name','created_at']);
            return $this->paginateToJson($query);
        }
    }

    public function show($id)
    {
        $item = Archive::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create()
    {
        $validator = $this->ruleValidator(ArchiveRule::rules(),ArchiveRule::message());
        if ($validator){
            return $validator;
        }
        try {

            $this->archive();

            Subject::query()->delete();
            Teacher::query()->delete();
            Group::query()->delete();

            return $this->json();

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    private function archive(){
        $query = Score::query()
            ->select(['teachers.name as teacher_name','subjects.name as subjects_name'])
            ->selectRaw('COUNT(scores.student_id) as student_count')
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.教学效果'),2) as 教学效果")
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.教学水平'),2) as 教学水平")
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.教学能力'),2) as 教学能力")
            ->selectRaw("ROUND(AVG(scores.meta->'$.score.project.total'),2) as avg")
            ->leftJoin('teachers','scores.teacher_id','=','teachers.id')
            ->leftJoin('subjects','scores.subject_id','=','subjects.id')
            ->groupBy(['subject_id','teacher_id']);

        $archive = $query->get();

        Archive::query()->create([
            'name' => $this->req->get('name'),
            'meta' => [
                'archive' => $archive
            ]
        ]);
    }

}
