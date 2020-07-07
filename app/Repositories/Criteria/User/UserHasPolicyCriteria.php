<?php


namespace App\Repositories\Criteria\User;


use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserHasPolicyCriteria implements CriteriaInterface
{

    private $policy_id;
    public function __construct($policy_id)
    {
        $this->policy_id = $policy_id;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('policies', fn(Builder $q) => $q->where('id', $this->policy_id));
    }
}
