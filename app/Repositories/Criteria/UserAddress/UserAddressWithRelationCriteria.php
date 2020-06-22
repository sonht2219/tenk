<?php


namespace App\Repositories\Criteria\UserAddress;


use App\Repositories\Criteria\Common\WithRelationsCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserAddressWithRelationCriteria extends WithRelationsCriteria
{
    public function __construct()
    {
        parent::__construct(['province', 'district']);
    }
}
