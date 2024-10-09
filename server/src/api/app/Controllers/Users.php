<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PHPUnit\Exception;

class Users extends ResourceController
{
    private $userModel;
    private $token = 'bb308b5f-1d97-478f-a28c-94ec7642da23';

    public function __construct()
    {
        $this->userModel = new \App\Models\UsersModel();
    }

    private function _validateToken()
    {
        return $this->request->getHeaderLine('Authorization') === $this->token;
    }

    public function list()
    {
        $data = $this->userModel->findAll();

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $response = [];

        if ($response = $this->_validateToken() === true) {
            $newUser = $this->request->getJSON(true);

            try {
                if ($this->userModel->insert($newUser)) {
                    $response = [
                        'response' => 'success',
                        'message' => 'Usuário criado com sucesso!'
                    ];
                } else {
                    $response = [
                        'response' => 'error',
                        'message' => 'Erro ao criar usuário.',
                        'errors' => $this->userModel->errors()
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'response' => 'error',
                    'message' => 'Erro ao criar usuário.',
                    'errors' => [
                        'exception' => $e->getMessage()
                    ]
                ];
            }
        } else {
            $response = [
                'response' => 'error',
                'message' => 'Token inválido',
            ];
        }

        return $this->response->setJSON($response);
    }
}