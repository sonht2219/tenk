<?php

namespace App\Repositories\Contract;

use App\Repositories\Common\Repository;

/**
 * Interface LotterySessionRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface LotterySessionRepository extends Repository
{
    public function findByIdWithRelations($id, $relations);
    public function listSessionOpeningAndEnded($limit);
    public function listSessionOfUserByStatus($user_id, $statuses, $limit);
    public function userJoinedSession($session_id, $user_id);
}
