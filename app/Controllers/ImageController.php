<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ImageController extends BaseController
{
    public function show($filename)
    {
        $path = WRITEPATH . 'uploads/blogs/' . $filename;

        if (!file_exists($path) || !is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));

        readfile($path);
        exit;
    }
}