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
}