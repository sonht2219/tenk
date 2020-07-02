<?php

namespace App\Repositories\Criteria\Bot;

use App\Repositories\Criteria\User\UserSearchCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BotSearchCriteria.
 *
 * @package namespace App\Repositories\Criteria\Bot;
 */
class BotSearchCriteria implements CriteriaInterface
{
    private $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('user', function (Builder $q) use ($repository) {
            return (new UserSearchCriteria($this->search))->apply($q, $repository);
        });
    }
}
