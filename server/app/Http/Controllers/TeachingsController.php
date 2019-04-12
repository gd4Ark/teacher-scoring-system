<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teaching;
use Illuminate\Http\Request;

class TeachingsController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('auth:api',[
            'except' => ['index','show']
        ]);
    }

    public function index()
    {
        if (!$this->req->has('groupId')){
            return $this->error('Necessary to have the `groupId` parameter');
        }
        $groupId = $this->req->input('groupId');
        $query =  Teaching::query()->where('group_id',$groupId);
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
        $item = Teaching::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create()
    {
        try {
            $input = $this->req->only(['group_id','subject_id','teacher_id']);
            $item = Teaching::query()->firstOrCreate($input);
            if ($item->wasRecentlyCreated){
                return $this->json($item);
            }
            return $this->error('existed');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update($id)
    {
        $item = Teaching::query()->findOrFail($id);
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
        $item = Teaching::query()->findOrFail($id);
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
                Teaching::query()->update($data);
                return $this->json();
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }

        $ids = (array)$this->req->get('ids');
        $data = $this->req->except('ids');
        try {
            Teaching::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch()
    {
        $ids = (array)$this->req->get('ids');
        try {
            Teaching::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
