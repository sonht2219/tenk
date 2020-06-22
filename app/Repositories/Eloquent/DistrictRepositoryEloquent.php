<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\DistrictRepository;
use App\Models\District;

/**
 * Class DistrictRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class DistrictRepositoryEloquent extends RepositoryEloquent implements DistrictRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return District::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
