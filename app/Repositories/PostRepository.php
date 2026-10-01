<?php

namespace App\Repositories;

use App\Models\Post;
use App\Support\ViewCounter;

class PostRepository
{
    public function find(int $id): ?array
    {
        $post = Post::with('categories')->find($id);

        if (!$post) {
            return null;
        }

        $data = $post->toArray();
        $data['views'] += ViewCounter::pending($id);

        return $data;
    }

    public function registerView(int $id): void
    {
        ViewCounter::register($id);
    }

    public function related(int $postId, array $categoryIds, int $limit = 3): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        $posts = Post::withCount(['categories as matches' => function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            }])
            ->whereHas('categories', fn ($q) => $q->whereIn('categories.id', $categoryIds))
            ->where('id', '!=', $postId)
            ->orderByDesc('matches')
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get()
            ->toArray();

        ViewCounter::mergeInto($posts);

        return $posts;
    }
}
