<?php


namespace App\Repositories\Criteria\Lottery;


use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotteryStatisticByDayCriteria implements CriteriaInterface
{

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->groupBy(DB::raw('date(created_at)'))
            ->select([
                DB::raw('date(created_at) as date'),
                DB::raw('count(*) as total_lottery')
            ]);
    }
}
