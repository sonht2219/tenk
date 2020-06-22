<?php


namespace App\Repositories\Criteria\LotteryReward;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class HasUserIdCriteria implements CriteriaInterface
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('user_id', $this->user_id);
    }
}
