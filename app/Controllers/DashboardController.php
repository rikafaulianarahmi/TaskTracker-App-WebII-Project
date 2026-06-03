<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('dashboard/index', [
            'name' => session()->get('user_name'),
            'role' => session()->get('role'),
        ]);
    }
}