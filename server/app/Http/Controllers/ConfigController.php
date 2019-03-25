<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    public function index()
    {
        $query = $this->queryFilter(Config::query());
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginate($query);
        }
    }

    public function create(Request $request)
    {
        try {
            $input = $request->all();
            $input['tpl'] = isset($input['tpl']) ? json_decode($input['tpl']) : [];
            $input['jump'] = isset($input['jump']) ? json_decode($input['jump']) : [];
            // Todo: Validate
            $item = Config::query()->create($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $item = Config::query()->findOrFail($id);
        return $this->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Config::query()->findOrFail($id);
        try {
            $input = $request->all();
            $input['tpl'] = isset($input['tpl']) ? json_decode($input['tpl']) : [];
            $input['jump'] = isset($input['jump']) ? json_decode($input['jump']) : [];
            // Todo: Validate
            $item->update($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = Config::query()->findOrFail($id);
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
            Config::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Config::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
