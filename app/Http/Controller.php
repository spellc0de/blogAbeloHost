<?php

namespace App\Http;

use App\Cache;
use Smarty;

abstract class Controller
{
    public function __construct(protected Smarty $view)
    {
    }

    protected function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->view->assign($key, $value);
        }

        $this->view->display($template);
    }

    protected function renderCached(string $cacheKey, int $ttl, string $template, callable $data): void
    {
        $cached = Cache::redis()->get($cacheKey);

        if ($cached !== null) {
            echo $cached;
            return;
        }

        foreach ($data() as $key => $value) {
            $this->view->assign($key, $value);
        }

        $html = $this->view->fetch($template);
        Cache::redis()->setex($cacheKey, $ttl, $html);

        echo $html;
    }

    protected function notFound(): void
    {
        http_response_code(404);
        $this->render('404.tpl');
    }
}
