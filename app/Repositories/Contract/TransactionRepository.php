<?php


namespace App\Repositories\Contract;


use App\Enum\DepositChannel;
use App\Repositories\Common\Repository;

interface TransactionRepository extends Repository
{
    public function createTransaction($data, $deposit_channel);
}
