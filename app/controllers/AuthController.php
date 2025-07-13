<?php

class AuthController extends Controller{

    public function index(){
        return $this->view('auth/signin');
    }

    public function authenticate(){
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Dummy check (replace with DB logic)
        if ($email === 'dis_admin5' && $password === '2025') {
            $_SESSION['user'] = ['email' => $email];
            redirect("./");
            // exit;
        }
        return $this->view('auth/signin', ['error' => 'Invalid credentials']);
    }

    public function logout(){
        unset($_SESSION['user']);
        session_destroy();
        header("Location: ./");
        exit;
    }

    public function auth(){
        echo "running";
        if (!isset($_SESSION['user'])) {
            header("Location: ./login");
            exit;
        }
    }
}
