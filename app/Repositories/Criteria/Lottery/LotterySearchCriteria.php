<?php


namespace App\Repositories\Criteria\Lottery;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotterySearchCriteria implements CriteriaInterface
{

    private string $search;
    public function __construct(string $search)
    {
        $this->search = $search;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $true_search = '%' . $this->search;
        return $model->where('serial', 'like', $true_search);
    }
}
