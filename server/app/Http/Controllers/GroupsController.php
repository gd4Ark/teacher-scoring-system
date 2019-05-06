<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Rules\GroupRule;
use Illuminate\Http\Request;

class GroupsController extends Controller
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
        $query = Group::query()->withCount([
            'students',
            'students as complete_count' => function ($query) {
                $query->where('complete', 1);
            },
            'teachings',
        ]);
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginateToJson($query);
        }
    }

    public function show($id)
    {
        $item = Group::query()->findOrFail($id);
        return $this->json($item);
    }

    public function create()
    {
        try {
            $groupList = $this->req->input('nameList',[]);
            $new_count = 0;
            $validator_count = 0;
            foreach ($groupList as $group){
                $validator = $this->ruleValidator(GroupRule::rules(),GroupRule::message(),$group);
                if ($validator){
                    $validator_count++;
                    continue;
                }
                $item = Group::query()->firstOrCreate($group);
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
        $validator = $this->ruleValidator(GroupRule::rules($item),GroupRule::message());
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
        $item = Group::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function updateBatch()
    {
        $ids = (array)$this->req->get('ids');
        $data = $this->req->except('ids');
        try {
            Group::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch()
    {
        $ids = (array)$this->req->get('ids');
        try {
            Group::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function updateAllow(){
        $query = Group::query();
        if ($this->req->get('all') != 1) {
            $query = $query->findOrFail($this->req->get('id'));
        }
        $validator = $this->ruleValidator(GroupRule::rules(),GroupRule::message());
        if ($validator){
            return $validator;
        }
        try{
            $query->update([
                'allow' => $this->req->get('allow')
            ]);
        }
        catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

}
