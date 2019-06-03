<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teaching\TeachingCreateRequest;
use App\Http\Requests\Teaching\TeachingUpdateRequest;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teaching;
use Illuminate\Http\Request;

class TeachingsController extends Controller
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
        $query = Teaching::query();
        $merge = null;

        if ($request->has('groupId')) {

            $id = $request->get('groupId');
            $merge = ['group' => Group::query()->findOrFail($id)];
            $query =  $query->where('group_id',$id);
        }
        else if ($request->has('subjectId')) {

            $id = $request->get('subjectId');
            $merge = ['subject' => Subject::query()->findOrFail($id)];
            $query =  $query->where('subject_id',$id);
        }
        else if ($request->has('teacherId')) {

            $id = $request->get('teacherId');
            $merge = ['teacher' => Teacher::query()->findOrFail($id)];
            $query =  $query->where('teacher_id',$id);
        }

        $query = $this->queryFilter($query);
        if ($request->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->success(array_merge(
                    $merge,
                    $this->paginate($query)->toArray()
                )
            );
        }
    }

    public function getOptions($query)
    {
        $ret = [];
        $data = $query->get();
        foreach ($data as $item){
            $ret[] = $item->data();
        }
        return $this->success($ret);
    }

    public function show($id)
    {
        $item = Teaching::query()->findOrFail($id);
        return $this->success($item);
    }

    public function create(TeachingCreateRequest $request)
    {
        $input = $request->all();
        try {
            $item = Teaching::query()->create($input);
            return $this->success($item);
        } catch (\Exception $e) {
            return $this->failed(env('APP_DEBUG') ? $e->getMessage() : '创建失败');
        }
    }

    public function update(TeachingUpdateRequest $request,$id)
    {
        $item = Teaching::query()->findOrFail($id);
        $input = $request->all();
        try {
            $item->update($input);
            return $this->success($item);
        } catch (\Exception $e) {
            return $this->failed(env('APP_DEBUG') ? $e->getMessage() : '更新失败');
        }
    }

    public function delete($id)
    {
        $item = Teaching::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed('删除失败');
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Teaching::query()->whereIn('id', $ids)->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed('删除失败');
        }
    }

}
