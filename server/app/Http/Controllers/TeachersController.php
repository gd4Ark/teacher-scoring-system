<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\ArchiveCreateRequest;
use App\Http\Requests\Teacher\ArchiveUpdateRequest;
use App\Http\Requests\Teacher\TeacherCreateRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Requests\Teaching\TeachingUpdateRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show']
        ]);
    }

    public function index(Request $request)
    {
        $query = Teacher::query();

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
            'teachings',
        ]);
    }

    public function show(Request $request,$id)
    {
        $item = Teacher::query()->findOrFail($id);
        if ($request->get('getTeachings') == 1){
            return $this->success($item->getTeachings());
        }
        return $this->success($item);
    }

    public function create(TeacherCreateRequest $request)
    {
        $names = $request->get('names');
        $names = split($names);
        $new_count = 0;
        try {
            foreach ($names as $name){
                $teacher = [
                    'name' => $name,
                ];
                $item = Teacher::query()->firstOrCreate($teacher);
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

    public function update(TeacherUpdateRequest $request, $id)
    {
        $item = Teacher::query()->findOrFail($id);
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
        $item = Teacher::query()->findOrFail($id);
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
            Teacher::query()->whereIn('id', $ids)->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed('删除失败');
        }
    }

}
