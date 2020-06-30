<?php


namespace App\Strategies\Payment\Base;


use App\Http\Requests\DepositCashRequest;
use App\User;

interface PaymentStrategy
{
    /**
     * @param DepositCashRequest $req
     * @param User $user
     * @return mixed
     */
    public function handle(DepositCashRequest $req, User $user);
}
