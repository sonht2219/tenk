<?php

namespace App\Repositories\Criteria\Article;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ArticleHasSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\Article;
 */
class ArticleHasSearchCriteria implements CriteriaInterface
{
    private $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function (Builder $q) {
            $search = '%' . $this->search . '%';
            $slugSearch = '%' . str_slug($this->search) . '%';

            return $q->where('title', 'like', $search)
                ->orWhere('slug', 'like', $slugSearch)
                ->orWhere('author', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->orWhere('content', 'like', $search);
        });
    }
}
