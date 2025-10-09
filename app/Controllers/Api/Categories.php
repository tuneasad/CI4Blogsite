<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoryModel;

class Categories extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    /**
     * List all categories
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}