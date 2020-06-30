<?php


namespace App\Strategies\Payment\Impls;


use App\Strategies\Payment\Base\PaymentStrategy;
use App\User;

class PaymentPhoneCardStrategy implements PaymentStrategy
{

    /**
     * @inheritDoc
     */
    public function handle($data, User $user)
    {
        // TODO: Implement handle() method.
    }
}
