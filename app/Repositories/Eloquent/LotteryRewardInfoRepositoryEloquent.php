<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\LotteryRewardInfoRepository;
use App\Models\LotteryRewardInfo;
use App\Validators\LotteryRewardInfoValidator;

/**
 * Class LotteryRewardInfoRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class LotteryRewardInfoRepositoryEloquent extends RepositoryEloquent implements LotteryRewardInfoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotteryRewardInfo::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
