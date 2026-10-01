<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\CategoryService;
use App\Validation\Rules\PositiveInteger;
use Smarty;

class CategoryController extends Controller
{
    public function __construct(Smarty $view, private CategoryService $categories)
    {
        parent::__construct($view);
    }

    public function show(array $params): void
    {
        if (!(new PositiveInteger())->passes($params['id'] ?? null)) {
            $this->notFound();
            return;
        }

        $categoryId = (int) $params['id'];
        $category = $this->categories->find($categoryId);

        if (!$category) {
            $this->notFound();
            return;
        }

        $sort = $_GET['sort'] ?? 'date';
        $page = $_GET['page'] ?? '1';
        $cacheKey = "page:category:{$categoryId}:{$sort}:{$page}";

        $this->renderCached($cacheKey, 60, 'category.tpl', fn () => [
            'category' => $category,
            ...$this->categories->paginatedPosts($categoryId, $_GET),
        ]);
    }
}
