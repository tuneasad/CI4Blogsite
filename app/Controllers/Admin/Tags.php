<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagModel;

class Tags extends BaseController
{
    public function index()
    {
        $tagModel = new TagModel();
        $data['tags'] = $tagModel->findAll();

        return view('admin/tags/index', $data);
    }

    public function create()
    {
        return view('admin/tags/create');
    }

    public function store()
    {
        $tagModel = new TagModel();
        if (!$this->validate($tagModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tagModel->save([
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/admin/tags')->with('message', 'Tag created successfully.');
    }

    public function edit($id)
    {
        $tagModel = new TagModel();
        $data['tag'] = $tagModel->find($id);

        return view('admin/tags/edit', $data);
    }

    public function update($id)
    {
        $tagModel = new TagModel();
        if (!$this->validate($tagModel->getValidationRules(['id' => $id]))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tagModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/admin/tags')->with('message', 'Tag updated successfully.');
    }

    public function delete($id)
    {
        $tagModel = new TagModel();
        $tagModel->delete($id);

        return redirect()->to('/admin/tags')->with('message', 'Tag deleted successfully.');
    }
}