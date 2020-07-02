<?php


namespace App\Repositories\Criteria\User;


use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserSearchCriteria implements CriteriaInterface
{

    private $search;
    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function (Builder $q) {
            $search = '%' . $this->search . '%';
            return $q->where('name', 'like', $search)
                ->orWhere('phone_number', 'like', $search)
                ->orWhere('email', 'like', $search);
        });
    }
}
