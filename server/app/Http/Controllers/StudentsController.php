<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show','login','submit']
        ]);
    }

    public function index()
    {
        $query =  Student::query();
        $merge = null;

        if ($this->req->has('groupId')){

            $id = $this->req->get('groupId');
            $merge = ['group' => Group::query()->findOrFail($id)];
            $query =  $query->where('group_id',$id);

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
            return $this->error('The student does not exist');
        }
        if ($group->allow == 0){
            return $this->error('This group is forbidden to scoring');
        }
        return $this->json($student);
    }

    public function submit(){
        $scores = (array)$this->req->get('scores');
        $uid = (int)$this->req->get('user_id');
        $user = Student::query()->findOrFail($uid);
        if($user->complete){
            return $this->error('The student has submitted');
        }
        if (!$user->group->allow){
            return $this->error('This group is forbidden to scoring');
        }
        try {
            foreach ($scores as $score){

                $base = [
                    'student_id' => $uid,
                    'group_id' => $user->group->id,
                    'subject_id' => $score['subject_id'],
                    'teacher_id' => $score['teacher_id']
                ];

                $total = 0;

                foreach ($score['projects'] as $project){
                    $total += (int)$project;
                }

                $score['projects']['total'] = $total;

                $meta = [
                    'score' => [
                        'project' => $score['projects'],
                        'suggest' => $score['suggest'],
                    ]
                ];

                Score::query()->firstOrCreate($base,array_merge($base,[
                    'meta' => $meta,
                ]));
            }
            $user->complete = 1;
            $user->save();
        }catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->json();
    }

}
