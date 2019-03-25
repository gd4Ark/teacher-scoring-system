<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    public function index()
    {
        $query = $this->queryFilter(Template::query());
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
            // Todo: Validate
            $item = Template::query()->create($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $item = Template::query()->findOrFail($id);
        return $this->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Template::query()->findOrFail($id);
        try {
            $input = $request->all();
            // Todo: Validate
            $item->update($input);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = Template::query()->findOrFail($id);
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
            Template::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Template::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
