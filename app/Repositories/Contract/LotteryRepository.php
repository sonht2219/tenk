<?php

namespace App\Repositories\Contract;

use App\Models\Lottery;
use App\Repositories\Common\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
    public function randomLotteries($session_id, $limit): Collection;
    public function countJoinTimesOfUserInSession($user_id, $session_id): int;
    public function findHistoryBuyLottery($session_id, $user_id);
    public function findUsersJoinedSession($session_id): Collection;
}
