<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    public function __construct(private PostRepository $posts)
    {
    }

    public function show(int $id): ?array
    {
        $post = $this->posts->find($id);

        if (!$post) {
            return null;
        }

        $this->posts->registerView($id);
        $post['views']++;

        $categoryIds = array_column($post['categories'], 'id');
        $post['related'] = $this->posts->related($id, $categoryIds);

        return $post;
    }
}
