<?php

class AdminController extends Controller
{
    public function __construct()
    {
        // Require authentication
        if (empty($_SESSION['user'])) {
            redirect('auth/login');
        }

        // Optional: Check for admin role
        if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] !== 'admin') {
            redirect('./');
        }
    }

    public function index()
    {
        return $this->view('admin/index', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function users()
    {
        $userModel = new User();
        $users = $userModel->all();

        return $this->view('admin/users', [
            'users' => $users
        ]);
    }

    public function delete_user($id)
    {
        $userModel = new User();
        $userModel->delete($id);

        redirect('admin/users');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        redirect('auth/login');
    }
}
