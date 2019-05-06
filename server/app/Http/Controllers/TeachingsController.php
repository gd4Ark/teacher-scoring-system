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

    public function index()
    {
        $query = Teaching::query();
        $merge = null;

        if ($this->req->has('groupId')) {

            $id = $this->req->get('groupId');
            $merge = ['group' => Group::query()->findOrFail($id)];
            $query =  $query->where('group_id',$id);
        }
        else if ($this->req->has('subjectId')) {

            $id = $this->req->get('subjectId');
            $merge = ['subject' => Subject::query()->findOrFail($id)];
            $query =  $query->where('subject_id',$id);
        }
        else if ($this->req->has('teacherId')) {

            $id = $this->req->get('teacherId');
            $merge = ['teacher' => Teacher::query()->findOrFail($id)];
            $query =  $query->where('teacher_id',$id);
        }

        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
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

    public function create()
    {
        try {
            $input = $this->req->only(['group_id', 'subject_id', 'teacher_id']);
            $item = Teaching::query()->firstOrCreate([
                'group_id' => $input['group_id'],
                'subject_id' => $input['subject_id'],
            ],$input);
            if ($item->wasRecentlyCreated) {
                return $this->json($item);
            }
            return $this->error('Subject already exists');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update($id)
    {
        $item = Teaching::query()->findOrFail($id);
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
        $item = Teaching::query()->findOrFail($id);
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
            Teaching::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
