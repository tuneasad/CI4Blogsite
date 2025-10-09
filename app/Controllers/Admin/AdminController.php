<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function admin_dashboard()
    {
        return view('admin/dashboard');
    }
}