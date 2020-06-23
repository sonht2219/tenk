<?php


namespace App\Repositories\Criteria\UserAddress;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserAddressHasTypeCriteria implements CriteriaInterface
{

    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('type', $this->type);
    }
}
