<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Archive;
use App\Rules\ArchiveRule;
use Illuminate\Http\Request;

class ArchivesController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show','create']
        ]);
    }

    public function index()
    {
        $query = Archive::query();
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
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
            $item = Archive::query()->create([
                'name' => $this->req->get('name'),
                'meta' => [
                    'archive' => $archive
                ]
            ]);

            return $this->json($item);

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = Archive::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function deleteBatch()
    {
        $ids = (array)$this->req->get('ids');
        try {
            Archive::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
