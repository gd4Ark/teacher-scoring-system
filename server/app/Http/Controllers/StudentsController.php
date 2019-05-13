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
            'except' => ['index','show','login','submit','completeInfo']
        ]);
    }

    public function index(Request $request)
    {

        if ($request->get('getComplete') == 1) {
            return $this->completeInfo();
        }

        $query =  Student::query();
        $merge = null;

        if ($request->has('groupId')){

            $id = $request->get('groupId');
            $merge = ['group' => Group::query()->findOrFail($id)];
            $query =  $query->where('group_id',$id);

        }

        $query = $this->queryFilter($query);
        if ($request->get('getOptions') == 1) {
            return $this->getOptions($query);
        } elseif ($request->get('getCount') == 1){
            return $this->json($query->count());
        } else {
            return $this->json(array_merge(
                    $merge,
                    $this->paginate($query)->toArray()
                )
            );
        }
    }

    private function completeInfo(){
        return $this->json([
            [
                'state' => '未完成',
                'count' => Student::query()->whereComplete(0)->count(),
            ],
            [
                'state' => '已完成',
                'count' => Student::query()->whereComplete(1)->count(),
            ],
        ]);
    }

    public function show($id)
    {
        $item = Student::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create(Request $request)
    {
        try {
            $group_id = $request->get('group_id');
            $names = $request->get('names');
            $names = explode("\n",$names);
            $new_count = 0;
            $validator_count = 0;
            foreach ($names as $name){
                $student = [
                    'name' => $name,
                    'group_id' => $group_id,
                ];
                $validator = $this->ruleValidator(StudentRule::rules(),StudentRule::message(),$student);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Student::query()->create($student);
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
        $item = Student::query()->findOrFail($id);
        $validator = $this->ruleValidator(StudentRule::rules($item),StudentRule::message());
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
        $item = Student::query()->findOrFail($id);
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
            Student::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('删除失败');
        }
    }

    public function login(Request $request){
        $group = Group::query()->findOrFail($request->get('groupId'));
        $student = Student::query()->findOrFail($request->get('studentId'));
        if ($student->group->id !== $group->id){
            return $this->error('该学生不存在');
        }
        if ($group->allow == 0){
            return $this->error('该班级禁止评分');
        }
        return $this->json($student);
    }

    public function submit(Request $request){
        $scores = (array)$request->get('scores');
        $uid = (int)$request->get('user_id');
        $user = Student::query()->findOrFail($uid);
        if($user->complete){
            return $this->error('不可重复提交');
        }
        if (!$user->group->allow){
            return $this->error('该班级禁止评分');
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
            return $this->error(env('APP_DEBUG') ? $e->getMessage() : '提交失败');
        }
        return $this->json();
    }

}
