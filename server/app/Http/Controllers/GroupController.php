<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class GroupController extends Controller
{

    public function index()
    {
        $query = Group::query()->withCount([
            'students as student_count',
            'students as complete_count' => function ($query) {
                $query->where('complete', 1);
            }
        ]);
        $query = $this->queryFilter($query);
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginate($query);
        }
    }

    public function create(Request $request)
    {
        try {
            $groups = $request->all();
            $res = true;
            foreach ($groups as $group){
                // Todo: Validate
                $res = Group::query()->firstOrCreate([
                    'name' => $group['name']
                ]);
            }
            return $this->json($res);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $item = Group::query()->findOrFail($id);
        return $this->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Group::query()->findOrFail($id);
        try{
            $validator  =   $this->validate($request, [
                'name' => 'required|unique:groups,name,' . $item->id,
            ],[
                'unique' => '唯一',
            ]);
            return $validator;
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
//        try {
//            $input = $request->all();
//            // Todo: Validate
//            $item->update($input);
//            return $this->json($item);
//        } catch (\Exception $e) {
//            return $this->error($e->getMessage(3));
//            $err = $e->getMessage();
//            switch ($e->getCode()){
//                case 1062:
//                        $err = '字段值已存在！';
//                        break;
//            }
//            return $this->error($err);
//        }
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

    public function updateBatch(Request $request)
    {
        if ($request->input('all') == 1){
            $data = $request->except('all');
            try {
                Group::query()->update($data);
                return $this->json();
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }

        $ids = (array)$request->get('ids');
        $data = $request->except('ids');
        try {
            Group::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Group::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
