<?php

namespace app\controllers;

class Controller
{
    protected $viewPath = 'app/views/';

    public function render($view, $data = [])
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        extract($data);
        require $this->viewPath . $view . '.php';
    }
}
