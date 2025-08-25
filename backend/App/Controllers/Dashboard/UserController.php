<?php

namespace App\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\User;

class UserController extends APIController
{
    protected $modelClass = User::class;

    public function index($id = null)
    {
        $user = $this->getModel();

        if ($id !== null) {
            $result = $user->find($id);
            if ($result) {
                $this->jsonResponse($result, 200);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'User not found.'], 404);
            }
        }

        if (!empty($_GET['search'])) {
            $users = $user->search($_GET['search']);
        } else {
            $users = $user->all();
        }

        $this->jsonResponse($users, 200);
    }

    function store()
    {
        $input = $this->getInput();

        $name = $input['name'] ?? null;
        $email = $input['email'] ?? null;
        $role = $input['role'] ?? null;
        $password = $input['password'] ?? null;

        if (!$name || !$email || !$role || !$password) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
        }

        $user = $this->getModel();
        $created = $user->create(
            $name,
            $email,
            $role,
            password_hash($password, PASSWORD_DEFAULT)
        );

        $this->jsonResponse([
            'success' => true,
            'message' => 'User created successfully.',
            'user' => $created
        ], 201);
    }

    public function update($id)
    {
        if (!$id) {
            $this->jsonResponse(['success' => false, 'message' => 'User ID missing.'], 400);
        }

        $input = $this->getInput();

        $name = $input['name'] ?? null;
        $email = $input['email'] ?? null;
        $role = $input['role'] ?? null;
        $password = $input['password'] ?? null;

        if (!$name || !$email || !$role) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
        }

        $user = $this->getModel();
        $existing = $user->find($id);

        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Handle password update logic
        if ($password !== null) {
            if (isset($existing['password']) && password_verify($password, $existing['password'])) {
                $user->update($id, $name, $email, $role);
            } else {
                $user->update($id, $name, $email, $role, password_hash($password, PASSWORD_DEFAULT));
            }
        } else {
            $user->update($id, $name, $email, $role);
        }

        $this->jsonResponse(['success' => true, 'message' => 'User updated successfully.'], 200);
    }

    public function delete($id)
    {
        if (!$id) {
            $this->jsonResponse(['success' => false, 'message' => 'User ID missing.'], 400);
        }

        $user = $this->getModel();
        $existing = $user->find($id);

        if (!$existing) {
            $this->jsonResponse(['success' => false, 'message' => 'User not found.'], 404);
        }

        $user->delete($id);
        $this->jsonResponse(['success' => true, 'message' => 'User deleted successfully.'], 200);
    }
}
