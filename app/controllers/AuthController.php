<?php

declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $email    = trim((string) ($_POST['email']    ?? ''));
            $password = (string) ($_POST['password'] ?? '');

            $errors = Validator::required($_POST, ['email', 'password']);
            if (!Validator::email($email)) {
                $errors['email'] = 'Please provide a valid email address.';
            }
            if ($errors !== []) {
                // Validation errors: show inline field errors, no attempts banner
                Session::set('login_field_errors', $errors);
                $this->redirect('/auth/login');
            }

            $userModel = new User();
            $user      = $userModel->findByEmail($email);

            if (!$user) {
                // Email not found — show generic inline error on email field, no countdown
                Session::set('login_field_errors', ['email' => 'No account found with that email address.']);
                $this->redirect('/auth/login');
            }

            // Lockout check
            if (!empty($user['locked_until']) && strtotime((string) $user['locked_until']) > time()) {
                $secondsLeft = max(0, strtotime((string) $user['locked_until']) - time());
                Session::set('login_locked_seconds', $secondsLeft);
                $this->redirect('/auth/login');
            }

            if (!password_verify($password, (string) $user['password'])) {
                $userModel->incrementLoginAttempts((int) $user['userId']);
                $fresh        = $userModel->find((int) $user['userId']);
                $attempts     = (int) ($fresh['login_attempts'] ?? 0);
                $maxAttempts  = 3;
                $attemptsLeft = max(0, $maxAttempts - $attempts);

                if ($attempts >= $maxAttempts) {
                    $userModel->lockAccount((int) $user['userId']);
                    Session::set('login_locked_seconds', 180);
                } else {
                    // Show remaining-attempts alert + inline password error
                    Session::set('login_attempts_banner', 'Invalid credentials. ' . $attemptsLeft . ' remaining attempt' . ($attemptsLeft === 1 ? '' : 's') . '.');
                    Session::set('login_field_errors', ['password' => 'Invalid password.']);
                }
                $this->redirect('/auth/login');
            }

            $userModel->resetLoginState((int) $user['userId']);
            Auth::login($user);

            if ((int) $user['role'] === 1) {
                $this->redirect('/admin/dashboard');
            }
            Session::flash('success', 'Welcome back, ' . (string) $user['firstname'] . '.');
            $this->redirect('/');
        }

        $this->view('auth/login', ['title' => 'Sign In']);
    }

    public function register(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $first    = trim((string) ($_POST['firstname'] ?? ''));
            $last     = trim((string) ($_POST['lastname']  ?? ''));
            $email    = trim((string) ($_POST['email']     ?? ''));
            $password = (string) ($_POST['password'] ?? '');

            $errors = Validator::required($_POST, ['firstname', 'lastname', 'email', 'password']);
            if (!Validator::email($email)) {
                $errors['email'] = 'Please provide a valid email address.';
            }
            if (!Validator::minLength($password, 8)) {
                $errors['password'] = 'Password must be at least 8 characters.';
            }

            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                $errors['email'] = 'Email already in use.';
            }

            if ($errors !== []) {
                if ($this->isAjax()) {
                    $this->json(['success' => false, 'errors' => array_values($errors)], 422);
                }
                Session::flash('error', implode(' ', array_values($errors)));
                $this->redirect('/auth/register');
            }

            $userModel->register([
                'firstname' => $first,
                'lastname'  => $last,
                'role'      => 0,
                'email'     => $email,
                'password'  => password_hash($password, PASSWORD_BCRYPT),
            ]);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Account created. You can now sign in.']);
            }

            Session::flash('success', 'Account created. Please sign in.');
            $this->redirect('/auth/login');
        }

        $this->view('auth/register', ['title' => 'Create Account']);
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }
}
