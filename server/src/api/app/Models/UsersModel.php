<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password'];
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'email' => 'required|min_length[3]|is_unique[users.email]',
    ];
}