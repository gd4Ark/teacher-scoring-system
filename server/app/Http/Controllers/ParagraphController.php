<?php

namespace App\Http\Controllers;

use App\Paragraph;
use Illuminate\Http\Request;

class ParagraphController extends Controller
{

    public function index()
    {
        $query = $this->queryFilter(Paragraph::query());
        if ($this->req->get('getOptions') == 1) {
            return $this->getOptions($query);
        } else {
            return $this->paginate($query);
        }
    }

    public function create(Request $request)
    {
        try {
            $file = $request->file('file');
            $keywords = $this->getFileLines($file);
            $num = count($keywords);
            $path = $this->MoveFile($file, 'app/char_data');
            // Todo: Validate
            $item = Paragraph::query()->create([
                'type' => 1,
                'name' => $request->get('name'),
                'key_name' => $request->get('key_name'),
                'num' => $num,
                'file' => $path
            ]);
            return $this->json($item);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $item = Paragraph::query()->findOrFail($id);
        return $this->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Paragraph::query()->findOrFail($id);
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
        $item = Paragraph::query()->findOrFail($id);
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
            Paragraph::query()->whereIn('id', $ids)->update($data);
            return $this->json();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteBatch(Request $request)
    {
        $ids = (array)$request->get('ids');
        try {
            Paragraph::query()->whereIn('id', $ids)->delete();
            return $this->json();
        } catch (\Exception $e) {
            return $this->error('Delete failed');
        }
    }

}
