<?php


namespace App\Repositories\Criteria\LotterySession;


use App\Repositories\Criteria\Common\WithRelationsCriteria;

class LotterySessionWithRelationCriteria extends WithRelationsCriteria
{
    public function __construct()
    {
        parent::__construct('product');
    }
}
