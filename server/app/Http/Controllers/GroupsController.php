<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Rules\GroupRule;
use Illuminate\Http\Request;

class GroupsController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show','completeInfo']
        ]);
    }

    public function index(Request $request)
    {
        if ($request->get('getComplete') == 1) {
            return $this->completeInfo();
        }
        $query = $this->getRelationCount(Group::query());
        $query = $this->queryFilter($query);
        if ($request->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginateToJson($query);
        }
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getRelationCount($query){
        return $query->withCount([
            'students',
            'students as complete_count' => function ($query) {
                $query->where('complete', 1);
            },
            'teachings',
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function completeInfo(){
        $query = Group::query()->select('id');
        $res = $this->getRelationCount($query)->get();
        return $this->json([
            [
                'state' => '未完成',
                'count' => $res->filter(function ($item){
                    return $item->students_count !== $item->complete_count;
                })->count()
            ],
            [
                'state' => '已完成',
                'count' => $res->filter(function ($item){
                    return $item->students_count === $item->complete_count;
                })->count()
            ],
        ]);
    }

    public function show($id)
    {
        $item = Group::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create(Request $request)
    {
        try {
            $names = $request->get('names');
            $names = $this->split($names);
            $new_count = 0;
            $validator_count = 0;
            foreach ($names as $name){
                $group = [
                    'name' => $name,
                ];
                $validator = $this->ruleValidator(GroupRule::rules(),GroupRule::message(),$group);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Group::query()->firstOrCreate($group);
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

    public function update(Request $request,$id)
    {
        $item = Group::query()->findOrFail($id);
        $validator = $this->ruleValidator(GroupRule::rules($item),GroupRule::message());
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
        $item = Group::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('删除失败');
        }
    }

    public function updateBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        $data = $request->except('ids');
        try {
            Group::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Group::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('删除失败');
        }
    }

    public function updateAllow(Request $request){
        $query = Group::query();
        if ($request->get('all') != 1) {
            $query = $query->findOrFail($request->get('id'));
        }
        $validator = $this->ruleValidator(GroupRule::rules(),GroupRule::message());
        if ($validator){
            return $validator;
        }
        try{
            $query->update([
                'allow' => $request->get('allow')
            ]);
        }
        catch (\Exception $e){
            return $this->error(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

}