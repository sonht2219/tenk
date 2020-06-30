<?php


namespace App\Service\Contract;


use App\Http\Requests\DepositCashRequest;
use App\User;

interface TransactionService
{
    public function createTransaction($user, $value, $status, $channel = null);
    public function depositCash(DepositCashRequest $req, User $user);
}
