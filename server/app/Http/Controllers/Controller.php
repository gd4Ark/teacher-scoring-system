<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    protected function getOptions($query)
    {
        $query->select('id as value', 'name as label');
        return $this->json($query->get());
    }

    protected function paginate($query,$isJson = true)
    {
        $per = (int)$this->req->get('per_page') ?: 15;
        $res = $query->paginate($per);
        return $isJson ? $this->json($res) : $res;
    }

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
        $orderBy = $this->req->get('order_by');
        $desc = $this->req->get('desc', 0);
        if ($orderBy) {
            $direction = (int)$desc === 1 ? 'desc' : 'asc';
            $query->orderBy($orderBy, $direction);
        }
        return $query;
    }

    public function ruleValidator($rule=[], $message=[])
    {
        $validator = Validator::make($this->req->all(), $rule, $message);

        if($validator->fails()){
            foreach($validator->errors()->getMessages() as $message){
                return $this->error($message[0]);
            }
        }
        return null;
    }

}
