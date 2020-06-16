<?php

namespace App\Repositories\Contract;

use App\Repositories\Common\Repository;

/**
 * Interface LotteryRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface LotteryRepository extends Repository
{
    public function removeRedundantLottery($product_id, $maxSerial);
}
