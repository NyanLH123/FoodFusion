<?php

namespace app\controllers;

use app\core\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view('home', ['title' => 'Home']);
    }

    public function about()
    {
        $this->view('about', ['title' => 'About Us']);
    }

    public function recipes()
    {
        $this->view('recipes', ['title' => 'Recipes']);
    }

    public function community()
    {
        $this->view('community', ['title' => 'Community']);
    }

    public function culinary()
    {
        $this->view('culinary', ['title' => 'Culinary']);
    }

    public function educational()
    {
        $this->view('educational', ['title' => 'Educational']);
    }

    public function privacy()
    {
        $this->view('privacy', ['title' => 'Privacy Policy']);
    }

    public function cookies()
    {
        $this->view('cookies', ['title' => 'Cookie Policy']);
    }

    public function contact()
    {
        $this->view('contact', ['title' => 'Contact Us']);
    }

}
