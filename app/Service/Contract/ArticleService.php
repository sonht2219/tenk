<?php


namespace App\Service\Contract;


use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ArticleService
{
    public function create(User $user, ArticleRequest $req): Article;

    /**
     * @param $id
     * @return Article
     * @throws ModelNotFoundException
     */
    public function single($id): Article;

    /**
     * @param $id
     * @param ArticleRequest $req
     * @return Article
     * @throws ModelNotFoundException
     */
    public function edit($id, ArticleRequest $req): Article;

    /**
     * @param $id
     * @return Article
     * @throws ModelNotFoundException
     */
    public function delete($id): Article;

    /**
     * @param int $limit
     * @param string|null $search
     * @param int|null $status
     * @return LengthAwarePaginator
     */
    public function list($limit, $search, $status): LengthAwarePaginator;
}
