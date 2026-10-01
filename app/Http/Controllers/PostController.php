<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Services\PostService;
use App\Validation\Rules\PositiveInteger;
use Smarty;

class PostController extends Controller
{
    public function __construct(Smarty $view, private PostService $posts)
    {
        parent::__construct($view);
    }

    public function show(array $params): void
    {
        if (!(new PositiveInteger())->passes($params['id'] ?? null)) {
            $this->notFound();
            return;
        }

        $post = $this->posts->show((int) $params['id']);

        if (!$post) {
            $this->notFound();
            return;
        }

        $this->render('post.tpl', [
            'post' => $post,
            'related' => $post['related'],
        ]);
    }
}
