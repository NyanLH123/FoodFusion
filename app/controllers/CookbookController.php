<?php

declare(strict_types=1);

class CookbookController extends Controller
{
    public function index(): void
    {
        $cookbookModel = new Cookbook();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $this->requireAuth();

            $title   = trim((string) ($_POST['title']   ?? ''));
            $content = trim((string) ($_POST['content'] ?? ''));
            $errors  = Validator::required($_POST, ['title', 'content']);
            $imagePath = null;

            if (!empty($_FILES['image']['name'])) {
                $upload = $this->handleCookbookImageUpload($_FILES['image']);
                if (!$upload['success']) {
                    $errors['image'] = (string) $upload['message'];
                } else {
                    $imagePath = (string) $upload['path'];
                }
            }

            if ($errors !== []) {
                Session::flash('error', implode(' ', array_values($errors)));
                $this->redirect('/cookbook/index');
            }

            $cookbookModel->create([
                'userId'           => (int) Auth::user()['userId'],
                'title'            => $title,
                'content'          => $content,
                'image'            => $imagePath,
                'created_at'       => date('Y-m-d H:i:s'),
                'totalshare'       => 0,
                'totalInteraction' => 0,
                'totalcomment'     => 0,
            ]);

            Session::flash('success', 'Post published.');
            $this->redirect('/cookbook/index');
        }

        $posts = $cookbookModel->allWithAuthors();
        $interactionState = [];
        if (Auth::check()) {
            $postIds = array_map(static fn(array $row): int => (int) $row['postId'], $posts);
            $interactionState = (new Interaction())->statesForPosts((int) Auth::user()['userId'], $postIds);
        }

        $this->view('cookbook/index', [
            'title'            => 'Community Cookbook',
            'posts'            => $posts,
            'interactionState' => $interactionState,
        ]);
    }

    // AJAX: like or bookmark a post
    public function interact(): void
    {
        if (!Auth::check()) {
            $this->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $postId  = (int) ($_POST['postId'] ?? 0);
        $type    = trim((string) ($_POST['type'] ?? 'like'));
        $allowed = ['like'];

        if ($postId <= 0 || !in_array($type, $allowed, true)) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 422);
        }

        $interactionModel = new Interaction();
        $cookbookModel    = new Cookbook();
        $userId           = (int) Auth::user()['userId'];

        $post = $cookbookModel->find($postId);
        if (!$post) {
            $this->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        $isLiked = $interactionModel->exists($postId, $userId, $type);
        if ($isLiked) {
            $interactionModel->remove($postId, $userId, $type);
            $cookbookModel->decrement('totalInteraction', $postId);
            $isLiked = false;
        } else {
            $interactionModel->create([
                'postId'    => $postId,
                'userId'    => $userId,
                'type'      => $type,
                'created_at'=> date('Y-m-d H:i:s'),
            ]);
            $cookbookModel->increment('totalInteraction', $postId);
            $isLiked = true;
        }

        $post = $cookbookModel->find($postId);
        $this->json([
            'success'          => true,
            'isLiked'          => $isLiked,
            'totalInteraction' => (int) ($post['totalInteraction'] ?? 0),
        ]);
    }

    // AJAX: submit a comment
    public function comment(): void
    {
        if (!Auth::check()) {
            $this->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $postId  = (int) ($_POST['postId'] ?? 0);
        $message = trim((string) ($_POST['message'] ?? ''));

        if ($postId <= 0 || $message === '') {
            $this->json(['success' => false, 'message' => 'Invalid input'], 422);
        }

        $commentModel  = new Comment();
        $cookbookModel = new Cookbook();

        $commentModel->create([
            'postId'    => $postId,
            'userId'    => (int) Auth::user()['userId'],
            'message'   => $message,
            'created_at'=> date('Y-m-d H:i:s'),
        ]);
        $cookbookModel->increment('totalcomment', $postId);

        $this->json(['success' => true]);
    }

    // AJAX: fetch comments for a post
    public function comments(): void
    {
        $postId = (int) ($_GET['postId'] ?? 0);
        if ($postId <= 0) {
            $this->json(['success' => false, 'comments' => []], 422);
        }

        $commentModel = new Comment();
        $this->json(['success' => true, 'comments' => $commentModel->byPost($postId)]);
    }

    // AJAX: increment share count
    public function share(): void
    {
        if (!Auth::check()) {
            $this->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $postId = (int) ($_POST['postId'] ?? 0);
        if ($postId <= 0) {
            $this->json(['success' => false, 'message' => 'Invalid post'], 422);
        }

        $cookbookModel = new Cookbook();
        $interactionModel = new Interaction();
        $userId = (int) Auth::user()['userId'];

        $post = $cookbookModel->find($postId);
        if (!$post) {
            $this->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        $alreadyShared = $interactionModel->exists($postId, $userId, 'share');
        if (!$alreadyShared) {
            $interactionModel->create([
                'postId'     => $postId,
                'userId'     => $userId,
                'type'       => 'share',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $cookbookModel->increment('totalshare', $postId);
        }

        $post = $cookbookModel->find($postId);

        $this->json([
            'success'     => true,
            'isShared'    => true,
            'alreadyShared' => $alreadyShared,
            'totalshare'  => (int) ($post['totalshare'] ?? 0),
            'message'     => $alreadyShared ? 'You already shared this post.' : 'Post shared to your profile.',
        ]);
    }

    private function handleCookbookImageUpload(array $file): array
    {
        if ((int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Image upload failed.'];
        }

        $size = (int) ($file['size'] ?? 0);
        if ($size <= 0 || $size > 5 * 1024 * 1024) {
            return ['success' => false, 'message' => 'Image must be smaller than 5 MB.'];
        }

        $tmpName = (string) ($file['tmp_name'] ?? '');
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = is_resource($finfo) ? (string) finfo_file($finfo, $tmpName) : '';
        if (is_resource($finfo)) {
            finfo_close($finfo);
        }

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/pjpeg'=> 'jpg',
            'image/jpg'  => 'jpg',
            'image/png'  => 'png',
            'image/x-png'=> 'png',
            'image/webp' => 'webp',
        ];

        $imageInfo = @getimagesize($tmpName);
        if ($imageInfo === false) {
            return ['success' => false, 'message' => 'Uploaded file is not a valid image.'];
        }

        $detectedMime = strtolower((string) ($imageInfo['mime'] ?? $mime));
        $resolvedExt = $extensions[$detectedMime] ?? $extensions[$mime] ?? null;

        $fromName = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        $fromName = $fromName === 'jpeg' ? 'jpg' : $fromName;
        if ($resolvedExt === null && in_array($fromName, ['jpg', 'png', 'webp'], true)) {
            $resolvedExt = $fromName;
        }

        if ($resolvedExt === null) {
            return ['success' => false, 'message' => 'Only JPG, PNG, and WEBP images are allowed.'];
        }

        $filename = 'cookbook_' . bin2hex(random_bytes(8)) . '.' . $resolvedExt;
        $relativePath = 'uploads/images/' . $filename;
        $absolutePath = ROOT_PATH . '/public/' . $relativePath;

        $dir = dirname($absolutePath);
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            return ['success' => false, 'message' => 'Upload directory is not writable.'];
        }

        if (!move_uploaded_file($tmpName, $absolutePath)) {
            return ['success' => false, 'message' => 'Failed to save uploaded image.'];
        }

        return ['success' => true, 'path' => $relativePath];
    }
}
