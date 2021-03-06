<?php


namespace App\Repositories\Criteria\Lottery;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotteryWithUserCriteria implements CriteriaInterface
{

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with(['user']);
    }
}
