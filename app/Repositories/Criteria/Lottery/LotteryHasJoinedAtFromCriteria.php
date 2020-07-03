<?php


namespace App\Repositories\Criteria\Lottery;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotteryHasJoinedAtFromCriteria implements CriteriaInterface
{

    private $from;

    public function __construct($from)
    {
        $this->from = $from;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('joined_at', '>=', $this->from);
    }
}
