<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\ProvinceRepository;
use App\Models\Province;

/**
 * Class ProvinceRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ProvinceRepositoryEloquent extends RepositoryEloquent implements ProvinceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Province::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
