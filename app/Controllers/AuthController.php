<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function save()
    {
        $userModel = new UserModel();
        $data = [
            'email'      => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        $userModel->save($data);
        return redirect()->to('/login');
    }
}
