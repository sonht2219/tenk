<?php


namespace App\Repositories\Criteria\LotterySession;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LotterySessionHasProductIdCriteria implements CriteriaInterface
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
        return $model->where('product_id', $this->product_id);
    }
}
