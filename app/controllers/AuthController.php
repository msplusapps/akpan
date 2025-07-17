<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Security;

class AuthController extends Controller{
    public function index()
    {
        return $this->view('auth/signin');
    }

    public function register()
    {
        return $this->view('auth/signup');
    }

    public function authenticate(){
        if (
            empty($_POST['csrf_token']) ||
            empty($_SESSION['csrf_token']) ||
            $_POST['csrf_token'] !== $_SESSION['csrf_token']
        ) {
            return $this->view('auth/signin', ['error' => 'Invalid CSRF token.']);
        }

        $username = trim($_POST['user'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            return $this->view('auth/signin', [
                'error' => 'Username and password are required.',
                'old'   => $_POST
            ]);
        }

        $userModel = new User();
        $user = $userModel->findOne($username, "email");

        show($user);

        if (!$user || Security::decrypt($user['password']) !== $password) {
            return $this->view('auth/signin', [
                'error' => 'Invalid credentials.',
                'old'   => $_POST
            ]);
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'] ?? $user['email'] ?? 'user'
        ];

        unset($_SESSION['csrf_token']);
        redirect("./admin/");
    }

    public function process_register(){
        if (
            empty($_POST['csrf_token']) ||
            empty($_SESSION['csrf_token']) ||
            $_POST['csrf_token'] !== $_SESSION['csrf_token']
        ) {
            return $this->view('auth/signup', ['error' => 'Invalid CSRF token.']);
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        $old = [
            'name' => $name,
            'email' => $email
        ];

        if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
            return $this->view('auth/signup', [
                'error' => 'All fields are required.',
                'old' => $old
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->view('auth/signup', [
                'error' => 'Invalid email format.',
                'old' => $old
            ]);
        }

        if ($password !== $confirm) {
            return $this->view('auth/signup', [
                'error' => 'Passwords do not match.',
                'old' => $old
            ]);
        }

        $userModel = new User();
        if ($userModel->findOne($email, 'email')) {
            return $this->view('auth/signup', [
                'error' => 'Email already registered.',
                'old' => $old
            ]);
        }

        $username = $this->generate_username();

        $success = $userModel->create([
            'name'     => $name,
            'email'    => $email,
            'username' => $username,
            'password' => Security::encrypt($password)
        ]);

        if (!$success) {
            return $this->view('auth/signup', [
                'error' => 'Registration failed. Try again.',
                'old' => $old
            ]);
        }

        $_SESSION['user'] = [
            'id' => $userModel->lastInsertId ?? null,
            'username' => $username
        ];

        unset($_SESSION['csrf_token']);
        redirect("../auth");
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        redirect();
    }

    public function auth()
    {
        if (!isset($_SESSION['user'])) {
            redirect('auth/login');
        }
    }

    protected function generate_username($prefix = 'user')
    {
        return strtolower($prefix) . rand(1000, 99999);
    }
}