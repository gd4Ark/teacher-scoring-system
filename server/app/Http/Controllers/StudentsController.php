<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show','login']
        ]);
    }

    public function index()
    {
        if (!$this->req->has('groupId')){
            return $this->error('Necessary to have the `groupId` parameter');
        }
        $groupId = $this->req->input('groupId');
        $query =  Student::query()->where('group_id',$groupId);
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->json(array_merge([
                'group' => Group::query()->where('id',$groupId)->first(),
            ],$this->paginate($query)->toArray()));
        }
    }

    public function show($id)
    {
        $item = Student::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create()
    {
        try {
            $nameList = $this->req->input('nameList',[]);
            $create_count = count($nameList);
            $new_count = 0;
            foreach ($nameList as $name){
                // Todo: Validate
                $item = Student::query()->firstOrCreate($name);
                if ($item->wasRecentlyCreated){
                    $new_count++;
                }
            }
            return $this->json([
                'create_count' => $create_count,
                'new_count' => $new_count,
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update($id)
    {
        $item = Student::query()->findOrFail($id);
        $validator = $this->ruleValidator($item->rules(),$item->ruleMessage());
        if ($validator){
            return $validator;
        }
        try {
            $input = $this->req->all();
            // Todo: Validate
            $item->update($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = Student::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function updateBatch()
    {
        if ($this->req->input('all') == 1){
            $data = $this->req->except('all');
            try {
                Student::query()->update($data);
                return $this->json();
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }

        $ids = (array)$this->req->get('ids');
        $data = $this->req->except('ids');
        try {
            Student::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch()
    {
        $ids = (array)$this->req->get('ids');
        try {
            Student::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function login(){
        if (!$this->req->has('groupId') || !$this->req->has('studentId')){
            return $this->error('Necessary to have the `groupId` and `studentId` parameter');
        }
        $group = Group::query()->findOrFail($this->req->get('groupId'));
        $student = Student::query()->findOrFail($this->req->get('studentId'));
        if ($student->group->id !== $group->id){
            return $this->error('该学生不存在');
        }
        if ($group->allow == 0){
            return $this->error('禁止登录');
        }
        return $this->json($student);
    }

}
