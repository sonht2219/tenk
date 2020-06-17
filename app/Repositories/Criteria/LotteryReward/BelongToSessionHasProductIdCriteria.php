<?php


namespace App\Repositories\Criteria\LotteryReward;


use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class BelongToSessionHasProductIdCriteria implements CriteriaInterface
{

    private $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @inheritDoc
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('session', function (Builder $q) {
            $q->where('product_id', $this->product_id);
        });
    }
}
