<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Repositories\Contract\ArticleRepository;
use App\Repositories\Criteria\Article\ArticleHasSearchCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Service\Contract\ArticleService;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleServiceImpl implements ArticleService
{
    private ArticleRepository $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function create(User $user, ArticleRequest $req): Article
    {
        $article = new Article($req->filteredData());
        $article->created_by()->associate($user);
        $article->slug = $this->generateSlug($req->title);
        return $this->articleRepo->save($article);
    }

    public function single($id): Article
    {
        return is_numeric($id)
            ? $this->articleRepo->find($id)
            : $this->articleRepo->findBySlug($id);
    }

    public function edit($id, ArticleRequest $req): Article
    {
        $article = $this->single($id);
        if ($article->title != $req->title)
            $article->slug = $this->generateSlug($req->title);

        $article->fill($req->filteredData());
        return $this->articleRepo->save($article);
    }

    public function delete($id): Article
    {
        $article = $this->single($id);
        $article->status = CommonStatus::INACTIVE;
        return $this->articleRepo->save($article);
    }

    public function list($limit, $search, $status): LengthAwarePaginator
    {
        if ($status)
            $this->articleRepo->pushCriteria(new HasStatusCriteria($status));

        if ($search)
            $this->articleRepo->pushCriteria(new ArticleHasSearchCriteria($search));

        return $this->articleRepo->paginate($limit);
    }

    private function generateSlug($title) {
        $slug = str_slug($title);
        return $this->articleRepo->exists(compact('slug'))
            ? $slug . '-' . round(microtime(true))
            : $slug;
    }
}
