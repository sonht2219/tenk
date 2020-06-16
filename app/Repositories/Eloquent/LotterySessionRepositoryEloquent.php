<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\LotterySessionRepository;
use App\Models\LotterySession;

/**
 * Class LotterySessionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class LotterySessionRepositoryEloquent extends RepositoryEloquent implements LotterySessionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotterySession::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
