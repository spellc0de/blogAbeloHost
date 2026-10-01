<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Router;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Services\CategoryService;
use App\Services\PostService;

$categoryService = new CategoryService(new CategoryRepository(), $config['posts_per_page']);
$postService = new PostService(new PostRepository());

$homeController = new HomeController($smarty, $categoryService);
$categoryController = new CategoryController($smarty, $categoryService);
$postController = new PostController($smarty, $postService);

$router->get('/', fn () => $homeController->index());
$router->get('/category/{id}', fn (array $params) => $categoryController->show($params));
$router->get('/post/{id}', fn (array $params) => $postController->show($params));

$router->fallback(function () use ($smarty) {
    http_response_code(404);
    $smarty->display('404.tpl');
});
