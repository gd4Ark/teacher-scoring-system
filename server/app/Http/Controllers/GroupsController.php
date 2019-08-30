<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\GroupCreateRequest;
use App\Http\Requests\Group\GroupUpdateAllowRequest;
use App\Http\Requests\Group\GroupUpdateRequest;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api', [
            'except' => ['index', 'show', 'completeInfo']
        ]);
    }

    public function index(Request $request)
    {
        $query = Group::query();

        $query = Group::getRelationCount($query);
        $query = $this->queryFilter($query);
        return $this->paginateToJson($query);
    }


    public function show($id)
    {
        $item = Group::query()->findOrFail($id);
        return $this->success($item);
    }

    public function create(GroupCreateRequest $request)
    {
        $names = $request->get('names');
        $names = split($names);
        $new_count = 0;
        foreach ($names as $name) {
            $group = [
                'name' => $name,
            ];

            $item = Group::query()->firstOrCreate($group);
            if ($item->wasRecentlyCreated) {
                $new_count++;
            }
        }
        return $this->success([
            'new_count' => $new_count,
            'fail_count' => count($names) - $new_count,
        ]);
    }

    public function update(GroupUpdateRequest $request, $id)
    {
        $item = Group::query()->findOrFail($id);
        $input = $request->all();
        $item->update($input);
        return $this->success($item);
    }

    public function delete($id)
    {
        $item = Group::query()->findOrFail($id);
        $item->delete();
        return $this->message('删除成功');
    }

    public function updateBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        $data = $request->except('ids');
        Group::query()->whereIn('id', $ids)->update($data);
        return $this->message('更新成功');
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        Group::query()->whereIn('id', $ids)->delete();
        return $this->message('删除成功');
    }

    public function updateAllow(GroupUpdateAllowRequest $request)
    {
        $query = Group::query();
        if (!$request->get('all')) {
            $query = $query->findOrFail($request->get('id'));
        }
        $query->update([
            'allow' => $request->get('allow')
        ]);
    }
}
