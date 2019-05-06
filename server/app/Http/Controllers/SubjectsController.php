<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Rules\SubjectRule;
use Illuminate\Http\Request;

class SubjectsController extends Controller
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
        $query = Subject::query()->withCount('teachings');
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginateToJson($query);
        }
    }

    public function show($id)
    {
        $item = Subject::query()->findOrFail($id);
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
                $validator = $this->ruleValidator(SubjectRule::rules(),SubjectRule::message(),$group);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Subject::query()->firstOrCreate($group);
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
        $item = Subject::query()->findOrFail($id);
        $validator = $this->ruleValidator(SubjectRule::rules($item),SubjectRule::message());
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
        $item = Subject::query()->findOrFail($id);
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
            Subject::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
