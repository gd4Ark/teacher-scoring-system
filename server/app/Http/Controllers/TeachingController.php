<?php

namespace App\Http\Controllers;

use App\Group;
use App\Teaching;
use Illuminate\Http\Request;

class TeachingController extends Controller
{
    /**
    * GroupController constructor.
    * @param Request $request
    */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        /**
         * 需要验证权限
         */
        $this->middleware('auth:api',[
            'only' => ['create','update','updateBatch','delete','deleteBatch']
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        try {
            $input = $this->req->all();
            $item = Teaching::query()->firstOrCreate($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = Teaching::query()->findOrFail($id);
        return $this->json($item);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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
