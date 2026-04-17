<?php

declare(strict_types=1);

class HomeController extends Controller
{
    public function index(): void
    {
        $cookbookModel = new Cookbook();
        $recipeModel   = new Recipe();
        $news = $cookbookModel->latest(3);
        $recipePreview = $recipeModel->latestWithAuthors(6);

        $events = [
            ['title' => 'Weekend Pasta Lab',           'text' => 'Hands-on class with experienced chef mentors.',          'img' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=1200&q=80'],
            ['title' => 'Farm to Table Meetup',        'text' => 'Local seasonal ingredient showcase and tasting session.', 'img' => 'https://images.unsplash.com/photo-1466637574441-749b8f19452f?auto=format&fit=crop&w=1200&q=80'],
            ['title' => 'Sustainable Kitchen Session', 'text' => 'Energy-smart cooking techniques for everyday kitchens.',  'img' => 'https://images.unsplash.com/photo-1514517093094-3d7f3188b6c9?auto=format&fit=crop&w=1200&q=80'],
        ];

        $this->view('home/index', [
            'title'         => 'FoodFusion',
            'news'          => $news,
            'recipePreview' => $recipePreview,
            'events'        => $events,
        ]);
    }

    public function about(): void
    {
        $this->view('about/index', ['title' => 'About']);
    }

    public function privacy(): void
    {
        $this->view('home/privacy', ['title' => 'Privacy Policy']);
    }

    public function cookies(): void
    {
        $this->view('home/cookies', ['title' => 'Cookie Policy']);
    }
}
