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
}
