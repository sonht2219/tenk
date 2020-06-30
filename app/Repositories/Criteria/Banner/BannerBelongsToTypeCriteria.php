<?php

namespace App\Repositories\Criteria\Banner;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BannerBelongsToTypeCriteria.
 *
 * @package namespace App\Repositories\Criteria\Banner;
 */
class BannerBelongsToTypeCriteria implements CriteriaInterface
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
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
        return $model->where('banner_type_id', $this->type);
    }
}
