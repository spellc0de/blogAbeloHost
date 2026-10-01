<?php

namespace App\Http;

class Router
{
    private array $routes = [];

    /** @var callable|null */
    private $fallback = null;

    public function get(string $pattern, callable $handler): void
    {
        $this->routes[] = [$pattern, $handler];
    }

    public function fallback(callable $handler): void
    {
        $this->fallback = $handler;
    }

    public function dispatch(string $uri): void
    {
        $path = trim(parse_url($uri, PHP_URL_PATH), '/');

        foreach ($this->routes as [$pattern, $handler]) {
            $trimmed = trim($pattern, '/');
            $regex = '#^' . preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $trimmed) . '$#';

            if (!preg_match($regex, $path, $matches)) {
                continue;
            }

            array_shift($matches);
            preg_match_all('#\{([a-zA-Z_]+)\}#', $trimmed, $names);
            $params = array_combine($names[1], $matches);

            $handler($params);
            return;
        }

        if ($this->fallback !== null) {
            ($this->fallback)();
        }
    }
}
