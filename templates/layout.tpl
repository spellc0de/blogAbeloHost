<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name="title"}Блог{/block}</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="/" class="logo">Блог</a>
        </div>
    </header>

    <main class="container">
        {block name="content"}{/block}
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; {$smarty.now|date_format:"%Y"} Тестовый блог</p>
        </div>
    </footer>
</body>
</html>
