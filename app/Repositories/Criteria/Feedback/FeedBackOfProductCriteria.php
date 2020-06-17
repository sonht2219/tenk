<?php

namespace App\Repositories\Criteria\Feedback;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FeedBackOfProductCriteria.
 *
 * @package namespace App\Repositories\Criteria\Feedback;
 */
class FeedBackOfProductCriteria implements CriteriaInterface
{
    private $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('product_id', $this->product_id);
    }
}
