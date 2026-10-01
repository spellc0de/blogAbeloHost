<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Validation\Rules\InArray;
use App\Validation\Rules\PositiveInteger;
use App\Validation\Validator;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categories,
        private int $perPage
    ) {
    }

    public function homepageCategories(): array
    {
        return $this->categories->withRecentPosts();
    }

    public function find(int $id): ?array
    {
        return $this->categories->find($id);
    }

    public function paginatedPosts(int $categoryId, array $query): array
    {
        $validator = new Validator($query);

        $sort = $validator->validate('sort', new InArray(['views', 'date']), 'date');
        $requestedPage = (int) $validator->validate('page', new PositiveInteger(), '1');

        $total = $this->categories->countPosts($categoryId);
        $pages = max(1, (int) ceil($total / $this->perPage));
        $page = max(1, min($pages, $requestedPage));

        $posts = $this->categories->posts($categoryId, $sort, $page, $this->perPage);

        return [
            'posts' => $posts,
            'sort' => $sort,
            'page' => $page,
            'pages' => $pages,
        ];
    }
}
