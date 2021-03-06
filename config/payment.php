<?php

use App\Enum\DepositChannel;
use App\Enum\Telco;
use App\Strategies\Payment\Impls\PaymentMoMoStrategy;
use App\Strategies\Payment\Impls\PaymentPhoneCardStrategy;
use App\Strategies\Payment\Impls\PaymentTransferBankStrategy;

return [
    'method' => [
        DepositChannel::MOMO => PaymentMoMoStrategy::class,
        DepositChannel::PHONE_CARD => PaymentPhoneCardStrategy::class,
        DepositChannel::TRANSFER_BANK => PaymentTransferBankStrategy::class
    ],
    'exchange_rate' => env('EXCHANGE_RATE_CASH', 1000),
    'phone_card' => [
        'api_url' => env('PHONE_CARD_API', 'http://doithecao.vip/api.php'),
        'email' => env('PHONE_CARD_EMAIL', 'diquadeongang@gmail.com'),
        'password' => env('PHONE_CARD_PASSWORD', 'FDJL#*($#((*#(*#(JFF&F^&^&^'),
        'telco' => [
            ['key' => Telco::getKey(Telco::VIETTEL), 'value' => Telco::VIETTEL],
            ['key' => Telco::getKey(Telco::MOBIFONE), 'value' => Telco::MOBIFONE],
            ['key' => Telco::getKey(Telco::VINAPHONE), 'value' => Telco::VINAPHONE],
        ],
        'values_card' => [
            ['key' => '10,000', 'value' => 10000],
            ['key' => '20,000', 'value' => 20000],
            ['key' => '30,000', 'value' => 30000],
            ['key' => '50,000', 'value' => 50000],
            ['key' => '100,000', 'value' => 100000],
            ['key' => '200,000', 'value' => 200000],
            ['key' => '300,000', 'value' => 300000],
            ['key' => '500,000', 'value' => 500000],
            ['key' => '1,000,000', 'value' => 1000000],
        ],
        'status' => [
            'cho_duyet' => 'Chờ Duyệt',
            'khong_hop_le' => 'Không Hợp Lệ',
            'da_nap' => 'Đã Nạp',
            'sai_menh_gia' => 'Sai Mệnh Giá',
            'khong_xac_dinh' => 'Không Xác Định',
        ]
    ]
];
