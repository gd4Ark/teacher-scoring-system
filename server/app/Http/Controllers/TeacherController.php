<?php

namespace App\Http\Controllers;

use App\Teacher;

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
            $students = $this->req->all();
            $create_count = count($students);
            $new_count = 0;
            foreach ($students as $student){
                // Todo: Validate
                $item = Teacher::query()->firstOrCreate($student);
                if ($item->wasRecentlyCreated){
                    $new_count++;
                }
            }
            return $this->json([
                'create_count' => $create_count,
                'new_count' => $new_count,
            ]);
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
