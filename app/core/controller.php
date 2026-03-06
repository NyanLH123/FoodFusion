<?php
namespace app\core;
require_once '../app/config/config.php';

class Controller {
    public function view($view, $data = [])
    {
        extract($data);
        $file = \APP_ROOT . '\views\\' . $view . '.php';

        if (file_exists($file)) {
            include $file;
        } else {
            echo $file;
            die('View not found');
        }
    }

    public function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function verifyCsrfToken($token) {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    public function regenerateCsrfToken() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}