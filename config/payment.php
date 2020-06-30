<?php

use App\Enum\DepositChannel;
use App\Strategies\Payment\Impls\PaymentMoMoStrategy;
use App\Strategies\Payment\Impls\PaymentPhoneCardStrategy;
use App\Strategies\Payment\Impls\PaymentTransferBankStrategy;

return [
    'method' => [
        DepositChannel::MOMO => PaymentMoMoStrategy::class,
        DepositChannel::PHONE_CARD => PaymentPhoneCardStrategy::class,
        DepositChannel::TRANSFER_BANK => PaymentTransferBankStrategy::class
    ],
    'exchange_rate' => env('EXCHANGE_RATE_CASH', 1000)
];
