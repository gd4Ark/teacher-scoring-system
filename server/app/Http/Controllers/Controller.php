<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{

    use ApiResponse;

    protected $req;

    public function __construct(Request $request)
    {
        $this->req = $request;
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getOptions($query)
    {
        $query->select('id as value', 'name as label');
        return $this->success($query->get());
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return mixed
     */
    protected function paginate($query)
    {
        $per = (int)$this->req->get('per_page') ?: 15;
        return $query->paginate($per);
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginateToJson($query)
    {
        return $this->success($this->paginate($query));
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
        $orderBy = $this->req->get('order_by');
        $desc = $this->req->get('desc', 0);
        if ($orderBy) {
            $direction = (int)$desc === 1 ? 'desc' : 'asc';
            $query->orderBy($orderBy, $direction);
        }
        return $query;
    }
}
