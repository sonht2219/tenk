<?php

namespace App\Repositories\Eloquent;

use App\Enum\Status\CommonStatus;
use App\Repositories\Common\RepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contract\LotteryRepository;
use App\Models\Lottery;
//use App\Validators\LotteryValidator;

/**
 * Class LotteryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class LotteryRepositoryEloquent extends RepositoryEloquent implements LotteryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lottery::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function removeRedundantLottery($product_id, $maxSerial)
    {
        $this->model->newQuery()
            ->where('product_id', $product_id)
            ->where('serial', '>=', $maxSerial)
            ->where('status', CommonStatus::ACTIVE)
            ->update(['status' => CommonStatus::INACTIVE]);
    }

    public function updateLotteries($ids, $attributes)
    {
        $this->model->newQuery()
            ->whereIn('id', $ids)
            ->update($attributes);
    }
}
