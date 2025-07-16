<?php

namespace App\Plugins\Auth\Controllers;

use Core\Controller;
use App\Plugins\Auth\Models\User;

class AuthController extends Controller {

    public function signin() {
        if ($this->isPost()) {
            $user = User::findOne(['username' => $this->input('username')]);

            if ($user && password_verify($this->input('password'), $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $this->redirect('/dashboard');
            } else {
                $this->view('Auth@auth/login', ['error' => 'Invalid credentials']);
            }
        } else {
            $this->view('Auth@auth/login');
        }
    }

    public function register() {
        if ($this->isPost()) {
            $user = new User();
            $user->username = $this->input('username');
            $user->email = $this->input('email');
            $user->password = password_hash($this->input('password'), PASSWORD_BCRYPT);
            $user->save();

            $this->redirect('/auth/login');
        } else {
            $this->view('Auth@auth/register');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/auth/login');
    }
}
