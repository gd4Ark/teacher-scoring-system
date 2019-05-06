<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Rules\TeacherRule;
use Illuminate\Http\Request;

class TeachersController extends Controller
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
        $query = Teacher::query()->withCount(['teachings']);
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginateToJson($query);
        }
    }

    public function show($id)
    {
        $item = Teacher::query()->findOrFail($id);
        if ($this->req->get('getTeachings') == 1){
            return $this->json($item->getTeachings());
        }
        return $this->json($item);
    }

    public function create()
    {
        try {
            $groupList = $this->req->input('nameList',[]);
            $new_count = 0;
            $validator_count = 0;
            foreach ($groupList as $group){
                $validator = $this->ruleValidator(TeacherRule::rules(),TeacherRule::message(),$group);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Teacher::query()->firstOrCreate($group);
                if ($item->wasRecentlyCreated){
                    $new_count++;
                }
            }
            return $this->json([
                'new_count' => $new_count,
                'validator_count' => $validator_count,
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update($id)
    {
        $item = Teacher::query()->findOrFail($id);
        $validator = $this->ruleValidator(TeacherRule::rules($item),TeacherRule::message());
        if ($validator){
            return $validator;
        }
        try {
            $input = $this->req->all();
            $item->update($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = Teacher::query()->findOrFail($id);
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
            Teacher::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
