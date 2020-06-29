<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Service\Contract\ArticleService;
use App\Service\Contract\DtoBuilderService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use AuthorizedController;

    /**
     * @var ArticleService
     */
    private ArticleService $articleService;
    /**
     * @var DtoBuilderService
     */
    private DtoBuilderService $dtoBuilder;

    public function __construct(ArticleService $articleService, DtoBuilderService $dtoBuilder)
    {
        $this->articleService = $articleService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function create(ArticleRequest $req)
    {
        return $this->dtoBuilder->buildArticleDto(
            $this->articleService->create($this->user(), $req)
        );
    }

    public function single($id)
    {
        return $this->dtoBuilder->buildArticleDto(
            $this->articleService->single($id)
        );
    }

    public function edit($id, ArticleRequest $req)
    {
        return $this->dtoBuilder->buildArticleDto(
            $this->articleService->edit($id, $req)
        );
    }

    public function delete($id)
    {
        return $this->dtoBuilder->buildArticleDto(
            $this->articleService->delete($id)
        );
    }

    public function list(Request $req)
    {
        $limit = $req->get('limit') ?: 20;
        $search = $req->get('search');
        $status = $req->get('status');

        $page = $this->articleService->list($limit, $search, $status);

        return [
            'datas' => collect($page->items())->map(fn($article) => $this->dtoBuilder->buildArticleDto($article)),
            'meta' => get_meta($page),
        ];
    }
}
