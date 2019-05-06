<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Score;
use App\Models\Student;
use App\Rules\StudentRule;
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
            $studentList = $this->req->input('nameList',[]);
            $new_count = 0;
            $validator_count = 0;
            foreach ($studentList as $student){
                $validator = $this->ruleValidator(StudentRule::rules(),StudentRule::message(),$student);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Group::query()->firstOrCreate($student);
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
        $item = Group::query()->findOrFail($id);
        $validator = $this->ruleValidator(StudentRule::rules($item),StudentRule::message());
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
        $item = Student::query()->findOrFail($id);
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
            Student::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function login(){
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
