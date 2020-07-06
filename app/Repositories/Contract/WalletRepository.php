<?php

namespace App\Repositories\Contract;

use App\Repositories\Common\Repository;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface WalletRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface WalletRepository extends Repository
{
    public function findByUser($user_id);
}
