<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teaching\TeachingCreateRequest;
use App\Http\Requests\Teaching\TeachingUpdateRequest;
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

    /**
     * @return array
     */
    private function getMerge()
    {
        $req = $this->req;
        $query = Teaching::query();
        $merge = [];

        $keys = [
            'group' => Group::query(),
            'subject' => Subject::query(),
            'teacher' => Teacher::query(),
        ];

        foreach ($keys as $key => $model) {
            if ($req->has($key . 'Id')) {
                $id = $req->get($key . 'Id');
                $merge = [$key => $model->findOrFail($id)];
                $query = $query->where($key . '_id', $id);
                break;
            }
        }

        return [
            $query,
            $merge,
        ];
    }

    public function index()
    {
        list($query, $merge) = $this->getMerge();

        $query = $this->queryFilter($query);
        return $this->success(array_merge(
            $merge,
            $this->paginate($query)->toArray()
        ));
    }

    public function show($id)
    {
        $item = Teaching::query()->findOrFail($id);
        return $this->success($item);
    }

    public function create(TeachingCreateRequest $request)
    {
        $input = $request->all();
        $item = Teaching::query()->create($input);
        return $this->success($item);
    }

    public function update(TeachingUpdateRequest $request, $id)
    {
        $item = Teaching::query()->findOrFail($id);
        $input = $request->all();
        $item->update($input);
        return $this->success($item);
    }

    public function delete($id)
    {
        $item = Teaching::query()->findOrFail($id);
        $item->delete();
        return $this->success($item);
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        Teaching::query()->whereIn('id', $ids)->delete();
        return $this->success($ids);
    }
}
