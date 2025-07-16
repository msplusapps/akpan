<?php

use Core\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        // Require authentication
        if (empty($_SESSION['user_id'])) {
            redirect('auth/login');
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

    public function cache()
    {
        return $this->view('admin/cache');
    }

    public function updateCache()
    {
        if (isset($_POST['cache_enabled'])) {
            Core\Utils\Cache::enable();
        } else {
            Core\Utils\Cache::disable();
        }
        redirect('admin/cache');
    }

    public function clearCache()
    {
        Core\Utils\Cache::clear();
        redirect('admin/cache');
    }
}
