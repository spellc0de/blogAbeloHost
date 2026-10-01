<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Models\Category;
use App\Models\Post;

Database::boot();

$categories = [
    ['name' => 'Технологии', 'description' => 'Новости и статьи о разработке, гаджетах и IT-индустрии.'],
    ['name' => 'Путешествия', 'description' => 'Заметки о городах, странах и маршрутах.'],
    ['name' => 'Кулинария', 'description' => 'Рецепты и советы по готовке.'],
    ['name' => 'Спорт', 'description' => 'Тренировки, соревнования и здоровый образ жизни.'],
];

$categoryModels = [];
foreach ($categories as $category) {
    $categoryModels[] = Category::create($category);
}

$titles = [
    'Как правильно выбрать ноутбук для разработки',
    'Топ-10 фреймворков 2026 года',
    'Что нового в PHP 8.4',
    'Гид по островам Юго-Восточной Азии',
    'Маршрут выходного дня по Грузии',
    'Как собрать рюкзак в поход',
    'Паста карбонара без сливок',
    'Пять способов приготовить курицу на ужин',
    'Домашний хлеб без дрожжей',
    'Как начать бегать: план для новичков',
    'Йога по утрам: с чего начать',
    'Подготовка к полумарафону',
    'Обзор новых смартфонов осени',
    'Гид по домашним офисным креслам',
    'Секреты продуктивности разработчика',
    'Лучшие пляжи Средиземноморья',
    'Что взять с собой в поездку в горы',
    'Простой рецепт борща',
    'Как приготовить идеальный стейк',
    'Утренняя растяжка за 10 минут',
];

$content = <<<HTML
<p>Это заглушка для текста статьи, в реальном посте здесь был бы полноценный контент с абзацами, списками и картинками.</p>
<p>Главное на этом этапе - проверить, что страница статьи корректно собирает заголовок, описание, категории и сам текст.</p>
HTML;

$imagesDir = __DIR__ . '/../public/assets/img/posts';

foreach ($titles as $i => $title) {
    $number = $i + 1;
    $image = "post-{$number}.png";

    if (!is_file("{$imagesDir}/{$image}")) {
        $image = null;
    }

    $post = Post::create([
        'title' => $title,
        'description' => 'Краткое описание статьи «' . $title . '» для превью на главной и в списке категории.',
        'content' => $content,
        'image' => $image,
        'views' => random_int(5, 500),
        'published_at' => (new DateTime())->modify('-' . random_int(0, 60) . ' days'),
    ]);

    $shuffled = $categoryModels;
    shuffle($shuffled);
    $count = random_int(1, 2);

    $post->categories()->attach(array_map(
        fn ($category) => $category->id,
        array_slice($shuffled, 0, $count)
    ));
}

echo 'Готово: добавлено ' . count($categories) . ' категорий и ' . count($titles) . ' статей' . PHP_EOL;
