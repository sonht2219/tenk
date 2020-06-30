<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use App\Repositories\Contract\BannerRepository;
use App\Models\Banner;

/**
 * Class BannerRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BannerRepositoryEloquent extends RepositoryEloquent implements BannerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banner::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
