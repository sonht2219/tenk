<?php

namespace App\Repositories\Contract;

use App\Repositories\Common\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface LotteryRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface LotteryRepository extends Repository
{
    public function removeRedundantLottery($product_id, $maxSerial);
    public function updateLotteries($ids, $attributes);
    public function historyLotterySession($session_id, $limit): LengthAwarePaginator;
}
