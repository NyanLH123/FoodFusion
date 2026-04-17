<?php

declare(strict_types=1);

class RecipeController extends Controller
{
    public function index(): void
    {
        $recipeModel = new Recipe();

        $filters = [
            'cuisine'          => trim((string) ($_GET['cuisine']          ?? '')),
            'dietary'          => trim((string) ($_GET['dietary']          ?? '')),
            'cookingdifficulty'=> trim((string) ($_GET['cookingdifficulty']?? '')),
        ];

        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 6;
        $total   = $recipeModel->countFiltered($filters);
        $pages   = max(1, (int) ceil($total / $perPage));
        $page    = min($page, $pages);
        $offset  = ($page - 1) * $perPage;

        $this->view('recipe/index', [
            'title'   => 'Recipes',
            'recipes' => $recipeModel->getPaginated($filters, $perPage, $offset),
            'filters' => $filters,
            'options' => $recipeModel->getFilters(),
            'page'    => $page,
            'pages'   => $pages,
        ]);
    }

    public function create(): void
    {
        $this->requireAuth();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $title        = trim((string) ($_POST['title'] ?? ''));
            $description  = trim((string) ($_POST['description'] ?? ''));
            $cuisine      = trim((string) ($_POST['cuisine'] ?? ''));
            $dietary      = trim((string) ($_POST['dietary'] ?? ''));
            $difficulty   = trim((string) ($_POST['cookingdifficulty'] ?? 'Easy'));
            $instructions = trim((string) ($_POST['instructions'] ?? ''));

            $errors = Validator::required($_POST, ['title', 'description', 'cuisine', 'dietary', 'cookingdifficulty', 'instructions']);
            if (!in_array($difficulty, ['Easy', 'Medium', 'Hard'], true)) {
                $errors['cookingdifficulty'] = 'Please choose a valid difficulty.';
            }

            $imagePath = null;
            if (!empty($_FILES['recipe_image']['name'])) {
                $upload = $this->handleRecipeImageUpload($_FILES['recipe_image']);
                if (!$upload['success']) {
                    $errors['recipe_image'] = (string) $upload['message'];
                } else {
                    $imagePath = (string) $upload['path'];
                }
            }

            if ($errors !== []) {
                Session::flash('error', implode(' ', array_values($errors)));
                $this->redirect('/recipe/create');
            }

            $recipeModel = new Recipe();
            $recipeId = $recipeModel->create([
                'userId'            => (int) Auth::user()['userId'],
                'title'             => $title,
                'description'       => $description,
                'cuisine'           => $cuisine,
                'dietary'           => $dietary,
                'cookingdifficulty' => $difficulty,
                'instructions'      => $instructions,
                'image'             => $imagePath,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);

            Session::flash('success', 'Recipe uploaded successfully.');
            $this->redirect('/recipe/show?id=' . $recipeId);
        }

        $this->view('recipe/create', ['title' => 'Share Recipe']);
    }

    public function show(?int $id = null): void
    {
        $id = $id ?: (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/recipe/index');
        }

        $recipeModel = new Recipe();
        $recipe      = $recipeModel->findWithAuthor($id);
        if (!$recipe) {
            Session::flash('error', 'Recipe not found.');
            $this->redirect('/recipe/index');
        }

        $this->view('recipe/show', [
            'title'       => (string) $recipe['title'],
            'recipe'      => $recipe,
            'ingredients' => $recipeModel->getIngredients($id),
        ]);
    }

    private function handleRecipeImageUpload(array $file): array
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
            return ['success' => false, 'message' => 'Only JPG, PNG, and WEBP are allowed.'];
        }

        $filename = 'recipe_' . bin2hex(random_bytes(8)) . '.' . $resolvedExt;
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
