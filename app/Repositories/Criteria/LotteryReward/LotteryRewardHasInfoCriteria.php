<?php

namespace App\Repositories\Criteria\LotteryReward;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LotteryRewardHasInfoCriteria.
 *
 * @package namespace App\Repositories\Criteria\LotteryReward;
 */
class LotteryRewardHasInfoCriteria implements CriteriaInterface
{
    private $has_info;

    public function __construct($has_info)
    {
        $this->has_info = $has_info;
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
        return $this->has_info
            ? $model->whereHas('info')
            : $model->whereDoesntHave('info');
    }
}
