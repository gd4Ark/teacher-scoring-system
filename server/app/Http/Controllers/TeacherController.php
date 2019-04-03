<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\Teaching;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function index()
    {
        $query = $this->queryFilter(Teacher::query());
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginate($query);
        }
    }

    public function create()
    {
        try {
            $groups = $this->req->all();
            $res = true;
            foreach ($groups as $group){
                // Todo: Validate
                $res = Teacher::query()->firstOrCreate([
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
        $item = Teacher::query()->findOrFail($id);
        return $this->json($item);
    }

    public function update($id)
    {
        $item = Teacher::query()->findOrFail($id);
        $validator = $this->ruleValidator($item->rules(),$item->ruleMessage());
        if ($validator){
            return $validator;
        }
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
        $item = Teacher::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function deleteBatch()
    {
        $ids = (array)$this->req->get('ids');
        try {
            Teacher::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
