<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboardpengguna extends BaseController
{
    public function index()
    {
        return view('admin/dashboard');
    }
}
