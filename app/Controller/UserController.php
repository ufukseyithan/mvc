<?php

namespace App\Controller;

class UserController extends Controller
{
    public function index() {
        $data = [
            'title' => 'User Dashboard',
            'message' => 'Welcome to the user dashboard!'
        ];

        return $this->view('user/index', $data);
    }

    public function show($id, $name = 'Ufuk') {
        $user = [
            'id' => $id,
            'name' => $name
        ];
        
        return $this->json($user);
    }

    public function create() {
        $user = [
            'id' => 123,
            'name' => 'Jane Doe'
        ];

        return $user;
    }
}