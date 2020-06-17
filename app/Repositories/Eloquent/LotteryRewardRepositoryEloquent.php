<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\LotteryRewardRepository;
use App\Models\LotteryReward;

/**
 * Class LotteryRewardRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class LotteryRewardRepositoryEloquent extends RepositoryEloquent implements LotteryRewardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotteryReward::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

}
