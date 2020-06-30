<?php


namespace App\Strategies\Payment\Base;


use App\User;

interface PaymentStrategy
{
    /**
     * @param $data
     * @param User $user
     * @return mixed
     */
    public function handle($data, User $user);
}
