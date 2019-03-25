<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{

    protected $req;

    public function __construct(Request $request)
    {
        $this->req = $request;
    }

    public function json($data = [], $status = true, $msg = '', $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ])->setStatusCode($statusCode);
    }

    public function msg($msg)
    {
        return $this->json([], true, $msg);
    }

    public function error($msg, $statusCode = 500)
    {
        return $this->json([], true, $msg, $statusCode);
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getOptions($query)
    {
        $query->select('id as value', 'name as label');
        return $this->json($query->get());
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginate($query)
    {
        $per = (int)$this->req->get('per_page') ?: 15;
        return $this->json($query->paginate($per));
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function queryFilter($query)
    {
        $wheres = $this->req->get('where');
        if (is_array($wheres)) {
            foreach ($wheres as $where) {
                $where = json_decode($where);
                if (($field = array_get($where, 0)) && ($op = array_get($where, 1))) {
                    if (!$value = array_get($where, 2)) {
                        $value = $op;
                        $op = '=';
                    }
                    $query->where($field, $op, $value);
                }
            }
        }
        return $query;
    }

    /**
     * @param $file \Illuminate\Http\UploadedFile
     * @return array
     */
    protected function getFileLines($file)
    {
        $lines = [];
        $file = $file->openFile();
        while ($line = $file->fgetcsv()) {
            $lines = array_merge($lines, $line);
        }
        return $lines;
    }

    /**
     * @param $file \Illuminate\Http\UploadedFile
     * @param $path string
     * @return string
     */
    protected function MoveFile($file, $path)
    {
        $filename = time() . rand(1000, 9999);
        $file->move(storage_path($path), $filename);
        return $path . '/' . $filename;
    }

}
