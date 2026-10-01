<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\CategoryService;
use Smarty;

class HomeController extends Controller
{
    public function __construct(Smarty $view, private CategoryService $categories)
    {
        parent::__construct($view);
    }

    public function index(): void
    {
        $this->renderCached('page:home', 60, 'home.tpl', fn () => [
            'categories' => $this->categories->homepageCategories(),
        ]);
    }
}
