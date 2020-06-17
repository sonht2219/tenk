<?php


namespace App\Repositories\Criteria\LotteryReward;


use App\Repositories\Criteria\Common\WithRelationsCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;

class LotteryRewardWithRelationsCriteria extends WithRelationsCriteria
{
    public function __construct()
    {
        parent::__construct(['session', 'session.product', 'user', 'lottery']);
    }
}
