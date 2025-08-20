<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Core\DotEnv;
use App\Core\Logger;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    public static function check(): bool
    {
        return (bool)(Session::get('user_id') ?? false);
    }

    public function showLogin()
    {
        $error = Session::getFlash('error');
        $this->view('auth/login', ['error' => $error]);
    }
    public function login()
    {
        $this->validateCsrfOrDie();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($email === '' || $password === '') {
            Session::flash('error', 'Email and password are required.');
            $this->redirect('/login');
        }
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            Session::set('user_id', (int)$user['id']);
            Session::set('user_name', $user['name']);
            Logger::log("User {$user['email']} logged in.");
            $this->redirect('/students');
        }
        Session::flash('error', 'Invalid credentials.');
        $this->redirect('/login');
    }
    public function showRegister()
    {
        $error = Session::getFlash('error');
        $this->view('auth/register', ['error' => $error]);
    }

    public function register()
    {
        $this->validateCsrfOrDie();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        if ($name === '' || $email === '' || $password === '') {
            Session::flash('error', 'Please fill required fields.');
            $this->redirect('/register');
        }
        if ($password !== $password2) {
            Session::flash('error', 'Passwords do not match.');
            $this->redirect('/register');
        }
        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            Session::flash('error', 'Email already exists.');
            $this->redirect('/register');
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // If role is not required, pass null or default value
        $userModel->create($name, $email, null, $hash);
        Logger::log("New user registered: $email");
        Session::flash('success', 'Account created. Please login.');
        $this->redirect('/login');
    }
    public function logout()
    {
        // var_dump($_SESSION);
        session_destroy();
        header('Location' . DotEnv::env('APP_URL') . '/auth/login');
        exit;
    }
}
