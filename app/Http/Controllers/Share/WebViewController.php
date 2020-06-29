<?php


namespace App\Http\Controllers\Share;


use App\Http\Controllers\Controller;
use App\Service\Contract\ArticleService;

class WebViewController extends Controller
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function article($slug)
    {
        $article = $this->articleService->single($slug);
        return view('web-views.article', compact('article'));
    }
}
