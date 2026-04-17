<?php

declare(strict_types=1);

return [
    'GET /' => 'HomeController@index',
    'GET /about' => 'HomeController@about',
    'GET /privacy' => 'HomeController@privacy',
    'GET /cookies' => 'HomeController@cookies',

    'GET /auth/login' => 'AuthController@login',
    'POST /auth/login' => 'AuthController@login',
    'GET /auth/register' => 'AuthController@register',
    'POST /auth/register' => 'AuthController@register',
    'POST /auth/logout' => 'AuthController@logout',
    'GET /auth/logout' => 'AuthController@logout',

    'GET /profile/index' => 'ProfileController@index',
    'POST /profile/index' => 'ProfileController@index',

    'GET /recipe/index' => 'RecipeController@index',
    'GET /recipe/create' => 'RecipeController@create',
    'POST /recipe/create' => 'RecipeController@create',
    'GET /recipe/show' => 'RecipeController@show',

    'GET /cookbook/index' => 'CookbookController@index',
    'POST /cookbook/index' => 'CookbookController@index',
    'POST /cookbook/interact' => 'CookbookController@interact',
    'POST /cookbook/comment' => 'CookbookController@comment',
    'GET /cookbook/comments' => 'CookbookController@comments',
    'POST /cookbook/share' => 'CookbookController@share',

    'GET /contact/index' => 'ContactController@index',
    'POST /contact/index' => 'ContactController@index',

    'GET /resources/index' => 'ResourceController@index',
    'GET /resources/culinary' => 'ResourceController@culinary',
    'GET /resources/educational' => 'ResourceController@educational',
    'GET /resources/download' => 'ResourceController@download',
    'GET /resources/upload' => 'ResourceController@upload',
    'POST /resources/upload' => 'ResourceController@upload',

    'GET /admin/dashboard' => 'AdminController@dashboard',
    'GET /admin/users' => 'AdminController@users',
    'POST /admin/users' => 'AdminController@users',
    'GET /admin/recipes' => 'AdminController@recipes',
    'POST /admin/recipes' => 'AdminController@recipes',
    'GET /admin/uploads' => 'AdminController@uploads',
    'POST /admin/uploads' => 'AdminController@uploads',
    'GET /admin/contacts' => 'AdminController@contacts',
    'POST /admin/contacts' => 'AdminController@contacts',
];