<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\GroupCreateRequest;
use App\Http\Requests\Group\GroupUpdateAllowRequest;
use App\Http\Requests\Group\GroupUpdateRequest;
use App\Models\Group;
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
        $query = Group::query();

        if ($request->has('getComplete')) {
            return $this->completeInfo();
        }
        if ($request->has('getOptions')){
            return $this->getOptions($query);
        }
        if ($request->has('getCount')){
            return $this->success($query->count());
        }

        $query = $this->getRelationCount($query);
        $query = $this->queryFilter($query);
        return $this->paginateToJson($query);
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
        return $this->success([
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
        return $this->success($item);
    }

    public function create(GroupCreateRequest $request)
    {
        $names = $request->get('names');
        $names = split($names);
        $new_count = 0;
        try {
            foreach ($names as $name){
                $group = [
                    'name' => $name,
                ];

                $item = Group::query()->firstOrCreate($group);
                if ($item->wasRecentlyCreated){
                    $new_count++;
                }
            }
            return $this->success([
                'new_count' => $new_count,
                'fail_count' => count($names) - $new_count,
            ]);
        } catch (\Exception $e) {
            return $this->failed(env('APP_DEBUG') ? $e->getMessage() : '创建失败');
        }
    }

    public function update(GroupUpdateRequest $request,$id)
    {
        $item = Group::query()->findOrFail($id);
        try {
            $input = $request->all();
            $item->update($input);
            return $this->success($item);
        } catch (\Exception $e) {
            return $this->failed(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

    public function delete($id)
    {
        $item = Group::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed('删除失败');
        }
    }

    public function updateBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        $data = $request->except('ids');
        try {
            Group::query()->whereIn('id', $ids)->update($data);
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Group::query()->whereIn('id', $ids)->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed('删除失败');
        }
    }

    public function updateAllow(GroupUpdateAllowRequest $request){
        $query = Group::query();
        if (!$request->get('all')) {
            $query = $query->findOrFail($request->get('id'));
        }
        try{
            $query->update([
                'allow' => $request->get('allow')
            ]);
        }
        catch (\Exception $e){
            return $this->failed(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

}