<?php


namespace App\Repositories\Criteria\Lottery;


use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotteryStatisticTopUserCriteria implements CriteriaInterface
{

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->groupBy('user_id')
            ->select([
                'user_id',
                DB::raw('count(*) as total_lottery')
            ])
            ->orderBy('total_lottery', 'desc');
    }
}
