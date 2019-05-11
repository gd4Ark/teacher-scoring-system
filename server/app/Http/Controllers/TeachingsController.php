<?php

namespace App\Http\Controllers;

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
            return $this->json(array_merge(
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
        return $this->json($ret);
    }

    public function show($id)
    {
        $item = Teaching::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create(Request $request)
    {
        try {
            $input = $request->only(['group_id', 'subject_id', 'teacher_id']);
            $item = Teaching::query()->firstOrCreate([
                'group_id' => $input['group_id'],
                'subject_id' => $input['subject_id'],
            ],$input);
            if ($item->wasRecentlyCreated) {
                return $this->json($item);
            }
            return $this->error('不可添加相同科目');
        } catch (\Exception $e) {
            return $this->error(env('APP_DEBUG') ? $e->getMessage() : '创建失败');
        }
    }

    public function update(Request $request,$id)
    {
        $item = Teaching::query()->findOrFail($id);
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
        $item = Teaching::query()->findOrFail($id);
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
            Teaching::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('删除失败');
        }
    }

}
