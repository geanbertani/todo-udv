<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController {
    private $userModel;

    public function __construct() {
        $this->userModel = new \App\Models\UsersModel();
    }

    public function list() {
        $data = $this->userModel->findAll();

        return $this->response->setJSON($data);
    }
}