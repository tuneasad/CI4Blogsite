<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('admin/categories/index', $data);
    }

    public function create()
    {
        return view('admin/categories/create');
    }

    public function store()
    {
        $categoryModel = new CategoryModel();
        if (!$this->validate($categoryModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $categoryModel->save([
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/admin/categories')->with('message', 'Category created successfully.');
    }

    public function edit($id)
    {
        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->find($id);

        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $categoryModel = new CategoryModel();
        if (!$this->validate($categoryModel->getValidationRules(['id' => $id]))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/admin/categories')->with('message', 'Category updated successfully.');
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();
        $categoryModel->delete($id);

        return redirect()->to('/admin/categories')->with('message', 'Category deleted successfully.');
    }
}