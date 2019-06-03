<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subject\SubjectCreateRequest;
use App\Http\Requests\Subject\SubjectUpdateRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
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
        $query = Subject::query();

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

    public function show(Request $request, $id)
    {
        $item = Subject::query()->findOrFail($id);
        if ($request->get('getTeachings') == 1){
            return $this->success($item->getTeachings());
        }
        return $this->success($item);
    }

    public function create(SubjectCreateRequest $request)
    {
        $names = $request->get('names');
        $names = split($names);
        $new_count = 0;
        try {
            foreach ($names as $name){
                $subject = [
                    'name' => $name,
                ];
                $item = Subject::query()->firstOrCreate($subject);
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

    public function update(SubjectUpdateRequest $request, $id)
    {
        $item = Subject::query()->findOrFail($id);
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
        $item = Subject::query()->findOrFail($id);
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
            Subject::query()->whereIn('id', $ids)->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed('删除失败');
        }
    }

}
