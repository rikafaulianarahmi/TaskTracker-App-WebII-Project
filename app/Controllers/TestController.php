<?php

namespace App\Controllers;

use App\Models\UserModel;

class TestController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        return $this->response->setJSON([
            'success' => true,
            'count' => $userModel->countAll()
        ]);
    }
}