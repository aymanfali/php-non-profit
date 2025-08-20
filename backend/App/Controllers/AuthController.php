<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\DotEnv;
use App\Core\Logger;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function checkSession()
    {
        header('Content-Type: application/json');
        $loggedIn = self::check();
        $sessionId = session_id();
        $sessionUserId = Session::get('user_id');
        $user = null;
        if ($loggedIn && $sessionUserId) {
            $userModel = new \App\Models\User();
            $user = $userModel->find($sessionUserId);
            if ($user) {
                unset($user['password']);
            }
        }
        echo json_encode([
            'loggedIn' => $loggedIn,
            'session_id' => $sessionId,
            'session_user_id' => $sessionUserId,
            'user' => $user,
            'cookies' => $_COOKIE
        ]);
        return;
    }
    public static function check(): bool
    {
        return (bool)(Session::get('user_id') ?? false);
    }

    public function showLogin()
    {
        header('Content-Type: application/json');
        $error = Session::getFlash('error');
        echo json_encode(['error' => $error]);
        return;
    }
    public function login()
    {
        if (strpos($_SERVER['REQUEST_URI'], '/api/auth/login') !== false) {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            $email = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';
            if ($email === '' || $password === '') {
                echo json_encode(['success' => false, 'error' => 'Email and password are required.']);
                return;
            }
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                Session::set('user_id', (int)$user['id']);
                Session::set('user_name', $user['name']);
                Logger::log("User {$user['email']} logged in.");
                echo json_encode(['success' => true, 'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'] ?? 'user'
                ]]);
                return;
            }
            echo json_encode(['success' => false, 'error' => 'Invalid credentials.']);
            return;
        }
    }

    public function showRegister()
    {
        header('Content-Type: application/json');
        $error = Session::getFlash('error');
        echo json_encode(['error' => $error]);
        return;
    }

    public function register()
    {
        if (strpos($_SERVER['REQUEST_URI'], '/api/auth/register') !== false) {
            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            $name = trim($data['name'] ?? '');
            $email = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';
            $password2 = $data['password2'] ?? '';
            $role = $data['role'] ?? null;
            if ($name === '' || $email === '' || $password === '') {
                echo json_encode(['success' => false, 'error' => 'Please fill required fields.']);
                return;
            }
            if ($password !== $password2) {
                echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
                return;
            }
            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                echo json_encode(['success' => false, 'error' => 'Email already exists.']);
                return;
            }
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $userModel->create($name, $email, $role, $hash);
            Logger::log("New user registered: $email");
            echo json_encode(['success' => true]);
            return;
        }
    }
    public function logout()
    {
        session_destroy();
        header('Content-Type: application/json');
        $user = [
            'id' => Session::get('user_id'),
            'name' => Session::get('user_name'),
        ];
        session_destroy();
        header('Content-Type: application/json');
        Logger::log("User {$user['name']} logged out.");
        echo json_encode([
            'success' => true,
            'message' => 'Logged out successfully.',
            'user' => $user
        ]);
        return;
    }
}
