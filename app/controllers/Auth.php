<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User as UserModel;
use app\core\Session;

class Auth extends Controller
{
    private $userModel;
    private $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = new Session();
    }
    
    public function index()
    {
        $this->view('register');
    }

    public function login()
    {
        $this->view('login');
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->view('login', ['error' => 'Please fill in all fields.']);
                return;
            }

            $user = $this->userModel->verifyPassword($email, $password);
            if ($user) {
                $this->session->set('user_id', $user['id']);
                $this->session->set('first_name', $user['first_name']);
                $this->session->set('last_name', $user['last_name']);
                $this->session->set('email', $user['email']);
                header('Location: ' . BASE_URL . 'home');
                exit();
            } else {
                $this->view('login', ['error' => 'Invalid email or password.']);
                header('Location: ' . BASE_URL . 'auth');
                exit();
            }
        } else {
            header('Location: ' . BASE_URL . 'auth');
            exit();
        }
    }

    public function logout()
    {
        // Destroy the session and redirect to login page
        session_destroy();
        header('Location: ' . BASE_URL . 'auth');
        exit();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Basic validation
            if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
                $this->view('login', ['error' => 'Please fill in all fields.']);
                return;
            }

            $existingUser = $this->userModel->IsExistingEmail($email);
            if ($existingUser) {
                $this->view('login', ['error' => 'Email already exists.']);
                return;
            }

            $this->userModel->createUser($first_name, $last_name, $email, $password);
            header('Location: ' . BASE_URL . 'home');
            exit();
        } else {
            header('Location: ' . BASE_URL . 'auth');
            exit();
        }
    }
}
