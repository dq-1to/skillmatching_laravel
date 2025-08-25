<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Report;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // resources/views/admin/dashboard.blade.php
    }
}
