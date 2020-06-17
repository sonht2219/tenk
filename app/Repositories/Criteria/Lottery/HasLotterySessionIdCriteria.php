<?php


namespace App\Repositories\Criteria\Lottery;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class HasLotterySessionIdCriteria implements CriteriaInterface
{
    private $session_id;
    public function __construct($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('session_id', $this->session_id);
    }
}
