<?php

namespace App\Repositories\Criteria\Banner;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BannerSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\Banner;
 */
class BannerSearchCriteria implements CriteriaInterface
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
            return $q->where('navigate_link', 'like', $search)
                ->orWhere('title', 'like', $search);
        });
    }
}
