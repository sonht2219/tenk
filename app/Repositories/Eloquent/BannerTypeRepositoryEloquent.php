<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\BannerTypeRepository;
use App\Models\BannerType;

/**
 * Class BannerTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BannerTypeRepositoryEloquent extends RepositoryEloquent implements BannerTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BannerType::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
