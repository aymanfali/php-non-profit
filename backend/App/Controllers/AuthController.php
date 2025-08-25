<?php

namespace App\Controllers;

use App\Core\APIController;
use App\Core\Logger;
use App\Core\Session;
use App\Models\User;

class AuthController extends APIController
{
    public function checkSession()
    {
        $loggedIn = self::check();
        $sessionId = session_id();
        $sessionUserId = Session::get('user_id');
        $user = null;

        if ($loggedIn && $sessionUserId) {
            $userModel = new User();
            $user = $userModel->find($sessionUserId);
            if ($user) {
                unset($user['password']);
            }
        }

        $this->jsonResponse([
            'loggedIn' => $loggedIn,
            'session_id' => $sessionId,
            'session_user_id' => $sessionUserId,
            'user' => $user,
            'cookies' => $_COOKIE
        ], 200);
    }

    public static function check(): bool
    {
        return (bool)(Session::get('user_id') ?? false);
    }

    public function showLogin()
    {
        $error = Session::getFlash('error');
        $this->jsonResponse(['error' => $error], 200);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if ($email === '' || $password === '') {
            return $this->jsonResponse(['success' => false, 'error' => 'Email and password are required.'], 400);
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            Session::set('user_id', (int)$user['id']);
            Session::set('user_name', $user['name']);
            Logger::log("User {$user['email']} logged in.");

            return $this->jsonResponse([
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'user'
                ]
            ], 200);
        }

        return $this->jsonResponse(['success' => false, 'error' => 'Invalid credentials.'], 401);
    }

    public function showRegister()
    {
        $error = Session::getFlash('error');
        $this->jsonResponse(['error' => $error], 200);
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $password2 = $data['password2'] ?? '';
        $role = $data['role'] ?? null;

        if ($name === '' || $email === '' || $password === '') {
            return $this->jsonResponse(['success' => false, 'error' => 'Please fill required fields.'], 400);
        }

        if ($password !== $password2) {
            return $this->jsonResponse(['success' => false, 'error' => 'Passwords do not match.'], 400);
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            return $this->jsonResponse(['success' => false, 'error' => 'Email already exists.'], 409);
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userModel->create($name, $email, $role, $hash);
        Logger::log("New user registered: $email");

        return $this->jsonResponse(['success' => true, 'message' => 'User registered successfully.'], 201);
    }

    public function logout()
    {
        $user = [
            'id' => Session::get('user_id'),
            'name' => Session::get('user_name'),
        ];

        session_destroy();
        Logger::log("User {$user['name']} logged out.");

        return $this->jsonResponse([
            'success' => true,
            'message' => 'Logged out successfully.',
            'user' => $user
        ], 200);
    }
}
