<?php


namespace App\Repositories\Criteria\Common;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrderByCreatedAtDescCriteria implements CriteriaInterface
{

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy('created_at', 'desc');
    }
}
