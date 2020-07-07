<?php

namespace App\Repositories\Contract;

use App\Models\PhoneCard;
use App\Repositories\Common\Repository;

/**
 * Interface PhoneCardRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface PhoneCardRepository extends Repository
{
    public function findByIdAndWithRelations($id, $relations = []);
    public function existCard($code, $seri): bool;
    public function findByCodeAndSeri($code, $seri);
    public function findByTransaction($transaction_id, $relations = []);
}
