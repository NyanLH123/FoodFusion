<?php

declare(strict_types=1);

abstract class Controller
{
    protected array $appConfig;

    public function __construct(array $appConfig = [])
    {
        $this->appConfig = $appConfig;
    }

    protected function view(string $viewName, array $data = [], string $layout = 'main'): void
    {
        // Make data variables available in view
        extract($data);

        $appConfig  = $this->appConfig;
        $base       = rtrim((string) ($appConfig['base_url'] ?? ''), '/');

        // Flash messages
        $flashSuccess = Session::getFlash('success');
        $flashError   = Session::getFlash('error');
        $flashInfo    = Session::getFlash('info');

        $currentUser  = Auth::user();

        // Render view into $content
        $viewFile = ROOT_PATH . '/app/views/' . str_replace('.', '/', $viewName) . '.php';
        if (!is_file($viewFile)) {
            http_response_code(500);
            echo "View not found: {$viewName}";
            exit;
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render layout
        $layoutFile = ROOT_PATH . '/app/views/layouts/' . $layout . '.php';
        if (!is_file($layoutFile)) {
            echo $content;
            return;
        }

        require $layoutFile;
    }

    protected function redirect(string $path): never
    {
        $base = rtrim((string) ($this->appConfig['base_url'] ?? ''), '/');
        header('Location: ' . $base . $path);
        exit;
    }

    protected function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $this->redirect('/auth/login');
        }
    }

    protected function requireAdmin(): void
    {
        if (!Auth::isAdmin()) {
            $this->redirect('/');
        }
    }

    protected function isAjax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
    }

    protected function input(string $key, mixed $default = ''): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}
