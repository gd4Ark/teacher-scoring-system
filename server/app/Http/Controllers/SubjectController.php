<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
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
        $query = $this->queryFilter(Subject::query());
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginateToJson($query);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        try {
            $students = $this->req->all();
            $create_count = count($students);
            $new_count = 0;
            foreach ($students as $student){
                // Todo: Validate
                $item = Subject::query()->firstOrCreate($student);
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = Subject::query()->findOrFail($id);
        return $this->json($item);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function update($id)
    {
        $item = Subject::query()->findOrFail($id);
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $item = Subject::query()->findOrFail($id);
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
    public function deleteBatch()
    {
        $ids = (array)$this->req->get('ids');
        try {
            Subject::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
