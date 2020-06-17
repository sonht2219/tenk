<?php

namespace App\Repositories\Criteria\LotterySession;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LotterySessionSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\LotterySession;
 */
class LotterySessionSearchCriteria implements CriteriaInterface
{
    private string $search;

    public function __construct(string $search)
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
        $search = $this->search;
        return $model->whereHas('product', function (Builder $q) use($search) {
            $normalSearch = "%$search%";
            $slugSearch = '%' . str_slug($search) . '%';
            return $q->where('slug', 'like', $slugSearch)
                ->orWhere('description', 'like', $normalSearch);
        });
    }
}
