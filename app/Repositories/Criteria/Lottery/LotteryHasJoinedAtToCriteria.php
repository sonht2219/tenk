<?php


namespace App\Repositories\Criteria\Lottery;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotteryHasJoinedAtToCriteria implements CriteriaInterface
{

    private $to;

    public function __construct($to)
    {
        $this->to = $to;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('joined_at', '<=', $this->to);
    }
}
