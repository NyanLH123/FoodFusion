<?php

declare(strict_types=1);

class ProfileController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $userModel = new User();
        $userId = (int) Auth::user()['userId'];

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $firstname = trim((string) ($_POST['firstname'] ?? ''));
            $lastname  = trim((string) ($_POST['lastname'] ?? ''));
            $email     = trim((string) ($_POST['email'] ?? ''));
            $password  = (string) ($_POST['password'] ?? '');

            $errors = Validator::required($_POST, ['firstname', 'lastname', 'email']);
            if (!Validator::email($email)) {
                $errors['email'] = 'Please provide a valid email address.';
            }
            if ($userModel->existsByEmailForOtherUser($email, $userId)) {
                $errors['email'] = 'That email is already used by another account.';
            }
            if ($password !== '' && !Validator::minLength($password, 8)) {
                $errors['password'] = 'New password must be at least 8 characters.';
            }

            if ($errors !== []) {
                Session::flash('error', implode(' ', array_values($errors)));
                $this->redirect('/profile/index');
            }

            $userModel->updateProfile($userId, $firstname, $lastname, $email);
            if ($password !== '') {
                $userModel->updatePassword($userId, password_hash($password, PASSWORD_BCRYPT));
            }

            $freshUser = $userModel->find($userId);
            if ($freshUser) {
                Auth::syncUser($freshUser);
            }

            Session::flash('success', 'Profile updated successfully.');
            $this->redirect('/profile/index');
        }

        $this->view('profile/index', [
            'title'            => 'My Profile',
            'user'             => $userModel->find($userId),
            'uploadedRecipes'  => $userModel->recentUploadedRecipes($userId),
            'uploadedCookbook' => $userModel->recentCookbookUploads($userId),
            'sharedCookbook'   => $userModel->recentSharedCookbookPosts($userId),
        ]);
    }
}
