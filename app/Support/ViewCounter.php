<?php

namespace App\Support;

use App\Cache;

class ViewCounter
{
    public const KEY_PREFIX = 'post:views:';

    public static function key(int $postId): string
    {
        return self::KEY_PREFIX . $postId;
    }

    public static function register(int $postId): void
    {
        Cache::redis()->incr(self::key($postId));
    }

    public static function pending(int $postId): int
    {
        return (int) (Cache::redis()->get(self::key($postId)) ?? 0);
    }

    public static function mergeInto(array &$posts): void
    {
        foreach ($posts as &$post) {
            $post['views'] += self::pending($post['id']);
        }
    }
}
