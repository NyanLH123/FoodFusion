<?php

declare(strict_types=1);

class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->requireAdmin();

        $userModel     = new User();
        $recipeModel   = new Recipe();
        $cookbookModel = new Cookbook();
        $contactModel  = new Contact();

        $stats = [
            'users'    => $userModel->count(),
            'recipes'  => $recipeModel->count(),
            'posts'    => $cookbookModel->count(),
            'messages' => $contactModel->count(),
        ];

        $recentPosts    = array_slice($cookbookModel->allWithAuthors(), 0, 5);
        $recentMessages = array_slice($contactModel->allInbox(), 0, 5);

        $this->view('admin/dashboard', [
            'title'           => 'Dashboard',
            'stats'           => $stats,
            'recentPosts'     => $recentPosts,
            'recentMessages'  => $recentMessages,
        ], 'admin');
    }

    public function users(): void
    {
        $this->requireAdmin();
        $userModel = new User();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $action = (string) ($_POST['action'] ?? '');
            $id     = (int)    ($_POST['userId'] ?? 0);

            if ($id > 0) {
                match ($action) {
                    'toggle_role' => $userModel->toggleRole($id),
                    'unlock'      => $userModel->unlock($id),
                    'delete'      => $userModel->delete($id),
                    default       => null,
                };
                Session::flash('success', 'User updated.');
            }
            $this->redirect('/admin/users');
        }

        $this->view('admin/users', [
            'title' => 'Users',
            'users' => $userModel->getAll(),
        ], 'admin');
    }

    public function recipes(): void
    {
        $this->requireAdmin();
        $recipeModel = new Recipe();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $action = (string) ($_POST['action']   ?? '');
            $id     = (int)    ($_POST['recipeId'] ?? 0);

            if ($action === 'delete' && $id > 0) {
                $recipe = $recipeModel->find($id);
                if ($recipe && !empty($recipe['image']) && !preg_match('#^https?://#', (string) $recipe['image'])) {
                    $file = ROOT_PATH . '/public/' . ltrim((string) $recipe['image'], '/');
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                $recipeModel->delete($id);
                Session::flash('info', 'Recipe deleted.');
                $this->redirect('/admin/recipes');
            }

            if ($action === 'create') {
                $errors = Validator::required($_POST, ['title', 'description', 'cuisine', 'dietary', 'cookingdifficulty', 'instructions']);
                if ($errors !== []) {
                    Session::flash('error', implode(' ', array_values($errors)));
                    $this->redirect('/admin/recipes');
                }

                $difficulty = (string) ($_POST['cookingdifficulty'] ?? 'Easy');
                $imagePath  = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80';

                if (!empty($_FILES['recipe_image']['name'])) {
                    $upload = $this->handleImageUpload($_FILES['recipe_image']);
                    if (!$upload['success']) {
                        Session::flash('error', $upload['message']);
                        $this->redirect('/admin/recipes');
                    }
                    $imagePath = $upload['path'];
                }

                $recipeModel->create([
                    'userId'            => (int) Auth::user()['userId'],
                    'title'             => trim((string) ($_POST['title']        ?? '')),
                    'description'       => trim((string) ($_POST['description']  ?? '')),
                    'cuisine'           => trim((string) ($_POST['cuisine']      ?? '')),
                    'dietary'           => trim((string) ($_POST['dietary']      ?? '')),
                    'cookingdifficulty' => in_array($difficulty, ['Easy','Medium','Hard'], true) ? $difficulty : 'Easy',
                    'instructions'      => trim((string) ($_POST['instructions'] ?? '')),
                    'image'             => $imagePath,
                ]);

                Session::flash('success', 'Recipe created.');
                $this->redirect('/admin/recipes');
            }
        }

        $this->view('admin/recipes', [
            'title'   => 'Recipes',
            'recipes' => $recipeModel->getAllWithAuthors(),
        ], 'admin');
    }

    public function uploads(): void
    {
        $this->requireAdmin();
        $resourceModel = new Resource();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $action = (string) ($_POST['action'] ?? '');

            if ($action === 'delete') {
                $id       = (int) ($_POST['resourceId'] ?? 0);
                $resource = $id > 0 ? $resourceModel->find($id) : null;
                if ($resource) {
                    $file = ROOT_PATH . '/public/' . ltrim((string) $resource['path'], '/');
                    if (is_file($file)) {
                        unlink($file);
                    }
                    $resourceModel->delete($id);
                    Session::flash('info', 'Resource deleted.');
                }
            } else {
                (new ResourceController($this->appConfig))->upload();
                return;
            }
            $this->redirect('/admin/uploads');
        }

        $this->view('admin/uploads', [
            'title'     => 'Resources',
            'resources' => $resourceModel->findAll(),
        ], 'admin');
    }

    public function contacts(): void
    {
        $this->requireAdmin();

        $contactModel = new Contact();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $action = trim((string) ($_POST['action'] ?? ''));
            if ($action === 'reply') {
                $messageId = (int) ($_POST['messageId'] ?? 0);
                $reply = trim((string) ($_POST['reply'] ?? ''));

                if ($messageId <= 0 || $reply === '') {
                    Session::flash('error', 'Reply message cannot be empty.');
                    $this->redirect('/admin/contacts');
                }

                $message = $contactModel->find($messageId);
                if (!$message) {
                    Session::flash('error', 'Message not found.');
                    $this->redirect('/admin/contacts');
                }
                if ((int) ($message['userId'] ?? 0) <= 0) {
                    Session::flash('error', 'Cannot send in-app reply to a guest message.');
                    $this->redirect('/admin/contacts');
                }

                $contactModel->addReply($messageId, (int) Auth::user()['userId'], $reply);
                Session::flash('success', 'Reply sent to user inbox.');
                $this->redirect('/admin/contacts');
            }
        }

        $messages = $contactModel->allInbox();
        $messageIds = array_map(static fn(array $row): int => (int) $row['messageId'], $messages);

        $this->view('admin/contacts', [
            'title'    => 'Contact Inbox',
            'messages' => $messages,
            'replies'  => $contactModel->repliesByMessageIds($messageIds),
        ], 'admin');
    }

    // Validate and move a recipe image upload
    private function handleImageUpload(array $file): array
    {
        if ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Upload failed.'];
        }

        $size = (int) $file['size'];
        if ($size > 5 * 1024 * 1024) {
            return ['success' => false, 'message' => 'Image must be 5 MB or smaller.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = (string) finfo_file($finfo, (string) $file['tmp_name']);
        finfo_close($finfo);

        $map = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (!isset($map[$mime])) {
            return ['success' => false, 'message' => 'Only JPG, PNG and WEBP allowed.'];
        }

        $filename = 'recipe_' . bin2hex(random_bytes(8)) . '.' . $map[$mime];
        $relative = 'uploads/images/' . $filename;
        $target   = ROOT_PATH . '/public/' . $relative;

        if (!move_uploaded_file((string) $file['tmp_name'], $target)) {
            return ['success' => false, 'message' => 'Could not save image.'];
        }

        return ['success' => true, 'path' => $relative];
    }
}
