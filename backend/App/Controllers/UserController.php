<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    // GET /users or /users/{id}
    function index($id = null)
    {
        header('Content-Type: application/json');
        $user = new User();
        if ($id !== null) {
            $result = $user->find($id);
            echo json_encode($result);
            return;
        }
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $users = $user->search($_GET['search']);
        } else {
            $users = $user->all();
        }
        echo json_encode($users);
    }

    function store()
    {
        header('Content-Type: application/json');
        $user = new User();
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($name === '' || $email === '' || $role === '' || $password === '') {
            $input = json_decode(file_get_contents('php://input'), true);
            $name = $input['name'] ?? $name;
            $email = $input['email'] ?? $email;
            $role = $input['role'] ?? $role;
            $password = $input['password'] ?? $password;
        }
        if ($name && $email && $role && $password) {
            $user->create(
                $name,
                $email,
                $role,
                password_hash($password, PASSWORD_DEFAULT)
            );
            echo json_encode(['success' => true, 'message' => 'User created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        }
    }

    // POST /users/update/{id}
    function update($id)
    {
        header('Content-Type: application/json');
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? '';
        $password = $_POST['password'] ?? null;
        if ($name === '' || $email === '' || $role === '') {
            $input = json_decode(file_get_contents('php://input'), true);
            $name = $input['name'] ?? $name;
            $email = $input['email'] ?? $email;
            $role = $input['role'] ?? $role;
            $password = $input['password'] ?? $password;
        }
        $user = new User();
        if ($id) {
            if ($password) {
                $user->update($id, $name, $email, $role, password_hash($password, PASSWORD_DEFAULT));
            } else {
                $user->update($id, $name, $email, $role);
            }
            echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User ID missing.']);
        }
    }

    // POST /users/delete/{id}
    function delete($id)
    {
        header('Content-Type: application/json');
        if ($id) {
            $user = new User();
            $existing = $user->find($id);
            if ($existing) {
                $user->delete($id);
                echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'User ID missing.']);
        }
    }
}
