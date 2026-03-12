<?php
namespace app\core;

class Router
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Determine Controller
        if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $controllerClass = 'app\\controllers\\' . $this->controller;

        if (class_exists($controllerClass)) {
            $this->controller = new $controllerClass;
        } else {
            die('Controller class not found: ' . $controllerClass);
        }

        // Determine Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];  // Don't die - return empty for homepage
    }
    
}
?>