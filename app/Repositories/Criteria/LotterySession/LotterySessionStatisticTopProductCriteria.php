<?php


namespace App\Repositories\Criteria\LotterySession;


use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotterySessionStatisticTopProductCriteria implements CriteriaInterface
{

    private $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->groupby('product_id')
            ->select([
                'product_id',
                DB::raw('sum(price) as total_revenue')
            ])
            ->orderBy('total_revenue', 'desc')
            ->limit($this->limit);
    }
}
