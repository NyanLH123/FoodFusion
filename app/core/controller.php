<?php
namespace app\core;
require_once '../app/config/config.php';

class Controller {
    public function view($view, $data = [])
    {
        $file = APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($file)) {
            extract($data);
            include $file;
        } else {
            http_response_code(500);
            die('View not found: ' . htmlspecialchars($view));
        }
    }
}
