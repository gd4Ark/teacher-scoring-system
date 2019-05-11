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

    public function index(Request $request)
    {
        $query = Subject::query()->withCount('teachings');
        $query = $this->queryFilter($query);
        if ($request->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginateToJson($query);
        }
    }

    public function show(Request $request, $id)
    {
        $item = Subject::query()->findOrFail($id);
        if ($request->get('getTeachings') == 1){
            return $this->json($item->getTeachings());
        }
        return $this->json($item);
    }

    public function create(Request $request)
    {
        try {
            $names = $request->get('names');
            $names = explode("\n",$names);
            $new_count = 0;
            $validator_count = 0;
            foreach ($names as $name){
                $subject = [
                    'name' => $name,
                ];
                $validator = $this->ruleValidator(SubjectRule::rules(),SubjectRule::message(),$subject);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Subject::query()->firstOrCreate($subject);
                if ($item->wasRecentlyCreated){
                    $new_count++;
                }
            }
            return $this->json([
                'new_count' => $new_count,
                'validator_count' => $validator_count,
            ]);
        } catch (\Exception $e) {
            return $this->error(env('APP_DEBUG') ? $e->getMessage() : '创建失败');
        }
    }

    public function update(Request $request, $id)
    {
        $item = Subject::query()->findOrFail($id);
        $validator = $this->ruleValidator(SubjectRule::rules($item),SubjectRule::message());
        if ($validator){
            return $validator;
        }
        try {
            $input = $request->all();
            $item->update($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

    public function delete($id)
    {
        $item = Subject::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('删除失败');
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Subject::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('删除失败');
        }
    }

}
