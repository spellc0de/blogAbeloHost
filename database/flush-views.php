<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Cache;
use App\Database;
use App\Support\ViewCounter;
use Illuminate\Database\Capsule\Manager as Capsule;

Database::boot();

$redis = Cache::redis();
$keys = $redis->keys(ViewCounter::KEY_PREFIX . '*');

$flushed = 0;

foreach ($keys as $key) {
    $pending = (int) $redis->getset($key, 0);

    if ($pending <= 0) {
        continue;
    }

    $postId = (int) str_replace(ViewCounter::KEY_PREFIX, '', $key);
    Capsule::table('posts')->where('id', $postId)->increment('views', $pending);
    $flushed++;
}

echo $flushed > 0
    ? "Разнесено просмотров по {$flushed} статьям\n"
    : "Нечего разносить\n";
