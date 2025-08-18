<?php
namespace App\Controllers;

use App\Core\DotEnv;
use App\Core\Session;
use App\Models\User;

class UserController
{

    function index()
    {
        if (!Session::get('user_id')) {
            header('Location:' . DotEnv::env('APP_URL') . '/auth/login');
            exit;
        }
        $user = new User();
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $users = $user->search($_GET['search']);
        } else {
            $users = $user->all();
        }
        require '../app/views/users/index.php';
    }

    function create()
    {
        require '../app/views/users/create.php';
    }

    function store()
    {
        $user = new User();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user->create(
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        );
    Session::set('success', 'User created successfully.');
    $this->index();
    }

    function edit()
    {
        $id = $_GET['id'] ?? null;
        $userModel = new User();
        $user = null;
        if ($id) {
            $user = $userModel->find($id);
        }
        require __DIR__ . '/../views/users/edit.php';
    }

    function update()
    {
        $id = $_POST['id'] ?? null;
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? null;
        $user = new User();
        if ($id) {
            if ($password) {
                $user->update($id, $email, password_hash($password, PASSWORD_DEFAULT));
            } else {
                $user->update($id, $email);
            }
            Session::set('success', 'User updated successfully.');
            header('Location:' . DotEnv::env('APP_URL') . '/users');
            exit;
        }
    }

    function delete()
    {
        $id = $_POST['id'] ?? null;

        if ($id) {
            $user = new User();
            $user->delete($id);
        }
    Session::set('success', 'User deleted successfully.');
    header('Location:' . DotEnv::env('APP_URL') . '/users');
    exit;
    }
}
