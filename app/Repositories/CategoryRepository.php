<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Support\ViewCounter;
use Illuminate\Database\Capsule\Manager as Capsule;

class CategoryRepository
{
    public function withRecentPosts(): array
    {
        $categories = Category::orderBy('name')->get();

        $rows = Capsule::select(<<<SQL
            SELECT * FROM (
                SELECT
                    p.id, p.title, p.description, p.image, p.views, p.published_at,
                    pc.category_id,
                    ROW_NUMBER() OVER (PARTITION BY pc.category_id ORDER BY p.published_at DESC) AS rn
                FROM posts p
                INNER JOIN post_category pc ON pc.post_id = p.id
            ) ranked
            WHERE rn <= 3
            ORDER BY category_id, published_at DESC
        SQL);

        $postsByCategory = [];

        foreach ($rows as $row) {
            $postsByCategory[$row->category_id][] = (array) $row;
        }

        $result = [];

        foreach ($categories as $category) {
            if (empty($postsByCategory[$category->id])) {
                continue;
            }

            $posts = $postsByCategory[$category->id];
            ViewCounter::mergeInto($posts);

            $result[] = [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'posts' => $posts,
            ];
        }

        return $result;
    }

    public function find(int $id): ?array
    {
        $category = Category::find($id);

        return $category ? $category->toArray() : null;
    }

    public function posts(int $categoryId, string $sort, int $page, int $perPage): array
    {
        $column = $sort === 'views' ? 'views' : 'published_at';

        $posts = Post::whereHas('categories', fn ($q) => $q->whereKey($categoryId))
            ->orderByDesc($column)
            ->forPage($page, $perPage)
            ->get()
            ->toArray();

        ViewCounter::mergeInto($posts);

        return $posts;
    }

    public function countPosts(int $categoryId): int
    {
        return Post::whereHas('categories', fn ($q) => $q->whereKey($categoryId))->count();
    }
}
