<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{

    public function index(Request $request)
    {
        $query = $this->queryFilter(Domain::query());
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        return $this->paginate($query);
    }

    public function create(Request $request)
    {
        try {
            $input = $request->all();
            $input['page_rank'] = isset($input['page_rank']) ? json_decode($input['page_rank']) : [];
            $input['request_num'] = isset($input['request_num']) ? json_decode($input['request_num']) : [];
            // Todo: Validate
            $item = Domain::query()->create($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $item = Domain::query()->findOrFail($id);
        return $this->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Domain::query()->findOrFail($id);
        try {
            $input = $request->all();
            isset($input['page_rank']) && $input['page_rank'] = json_decode($input['page_rank']);
            isset($input['request_num']) && $input['request_num'] = json_decode($input['request_num']);
            // Todo: Validate
            $item->update($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = Domain::query()->findOrFail($id);
        try {
            $item->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

    public function updateBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        $data = $request->except('ids');
        try {
            Domain::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Domain::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
