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
        $this->middleware('auth:api', [
            'except' => ['index', 'show']
        ]);
    }

    public function index(Request $request)
    {
        $query = Subject::query();

        $query = $this->getRelationCount($query);
        $query = $this->queryFilter($query);
        return $this->paginateToJson($query);
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getRelationCount($query)
    {
        return $query->withCount([
            'teachings',
        ]);
    }

    public function show(Request $request, $id)
    {
        $item = Subject::query()->findOrFail($id);
        if ($request->get('getTeachings') == 1) {
            return $this->success($item->getTeachings());
        }
        return $this->success($item);
    }

    public function create(SubjectCreateRequest $request)
    {
        $names = $request->get('names');
        $names = split($names);
        $new_count = 0;

        foreach ($names as $name) {
            $subject = [
                'name' => $name,
            ];
            $item = Subject::query()->firstOrCreate($subject);
            if ($item->wasRecentlyCreated) {
                $new_count++;
            }
        }
        return $this->success([
            'new_count' => $new_count,
            'fail_count' => count($names) - $new_count,
        ]);
    }

    public function update(SubjectUpdateRequest $request, $id)
    {
        $item = Subject::query()->findOrFail($id);
        $input = $request->all();
        $item->update($input);
        return $this->success($item);
    }

    public function delete($id)
    {
        $item = Subject::query()->findOrFail($id);
        $item->delete();
        return $this->success($item);
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        Subject::query()->whereIn('id', $ids)->delete();
        return $this->success($ids);
    }
}
