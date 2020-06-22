<?php

namespace App\Repositories\Criteria\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\Product;
 */
class ProductSearchCriteria implements CriteriaInterface
{
    private string $search;

    public function __construct(string $search)
    {
        $this->search = $search;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function (Builder $q) {
            $search = "%" . $this->search . "%";
            $slugSearch = '%' . str_slug($this->search) . '%';
            return $q->where('slug', 'like', $slugSearch)
                ->orWhere('name', 'like', $search)
                ->orWhere('description', 'like', $search);
        });
    }
}
