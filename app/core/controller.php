<?php 
namespace app\core;
use app\core\Session;

class Controller {
    public function __construct()
    {
        Session::init();
    }

    public function view($view, $data = [])
    {
        $viewPath = \APP_ROOT . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            extract($data);
            require $viewPath;
        } else {
            throw new \Exception("View not found: $view");
        }
    }
}
?>