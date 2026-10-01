# Блог

Блог на чистом PHP 8 без фреймворков: категории со статьями, сортировка, пагинация, похожие статьи.

## Стек

- PHP 8.1+, без фреймворка.
- MySQL 8
- Smarty - шаблонизатор
- Eloquent (illuminate/database) - ORM и построитель схемы для миграций
- Redis - счётчик просмотров статей, кеш главной и страниц категорий (60 сек)
- SCSS для стилей
- Docker


```
cp .env.example .env
```

```
docker compose up -d --build
docker compose exec app php database/migrate.php
docker compose exec app php database/seed.php
```

Сайт будет доступен на http://localhost:8080