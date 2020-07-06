<?php

namespace App\Repositories\Criteria\Lottery;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class IsBoughtByBotCriteria.
 *
 * @package namespace App\Repositories\Criteria\Lottery;
 */
class LotteryBoughtByUserCriteria implements CriteriaInterface
{
    private bool $is_bought_by_user;

    public function __construct($is_bought_by_user = true)
    {
        $this->is_bought_by_user = $is_bought_by_user;
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
        return $model->where('bot_id', $this->is_bought_by_user ? '=' : '<>', 0);
    }
}
