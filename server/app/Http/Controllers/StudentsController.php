<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentLoginRequest;
use App\Http\Requests\Student\StudentSubmitRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Models\Group;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api', [
            'except' => ['index', 'show', 'login', 'submit', 'completeInfo']
        ]);
    }

    public function index(Request $request)
    {
        $query = Student::query();
        $merge = null;

        if ($request->has('groupId')) {
            $id = $request->get('groupId');
            $merge = ['group' => Group::query()->findOrFail($id)];
            $query = $query->where('group_id', $id);
        }

        $query = $this->queryFilter($query);

        return $this->success(array_merge(
            $merge,
            $this->paginate($query)->toArray()
        ));
    }

    public function show($id)
    {
        $item = Student::query()->findOrFail($id);
        return $this->success($item);
    }

    public function create(StudentCreateRequest $request)
    {
        $group_id = $request->get('group_id');
        $names = $request->get('names');
        $names = split($names);
        $new_count = 0;

        foreach ($names as $name) {
            $student = [
                'name' => $name,
                'group_id' => $group_id,
            ];
            $item = Student::query()->create($student);
            if ($item->wasRecentlyCreated) {
                $new_count++;
            }
        }
        return $this->success([
            'new_count' => $new_count,
            'fail_count' => count($names) - $new_count,
        ]);
    }

    public function update(StudentUpdateRequest $request, $id)
    {
        $item = Student::query()->findOrFail($id);
        $input = $request->all();
        $item->update($input);
        return $this->success($item);
    }

    public function delete($id)
    {
        $item = Student::query()->findOrFail($id);
        $item->delete();
        return $this->success($item);
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');

        Student::query()->whereIn('id', $ids)->delete();
        return $this->success($ids);
    }

    public function login(StudentLoginRequest $request)
    {
        $student = Student::query()->findOrFail($request->get('user_id'));
        return $this->success($student);
    }

    public function submit(StudentSubmitRequest $request)
    {
        $scores = (array)$request->get('scores');
        $uid = $request->get('user_id');
        $user = Student::query()->findOrFail($uid);

        foreach ($scores as $score) {
            $base = [
                'student_id' => $uid,
                'group_id' => $user->group->id,
                'subject_id' => $score['subject_id'],
                'teacher_id' => $score['teacher_id']
            ];

            $total = array_sum($score['projects']);

            $score['projects']['total'] = $total;

            $meta = [
                'score' => [
                    'project' => $score['projects'],
                    'suggest' => $score['suggest'],
                ]
            ];

            Score::query()->firstOrCreate($base, array_merge($base, [
                'meta' => $meta,
            ]));
        }

        $user->complete = 1;
        $user->save();
        return $this->message('提交成功');
    }
}
