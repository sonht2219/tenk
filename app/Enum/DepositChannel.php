<?php


namespace App\Enum;


use App\Enum\Contract\LocalEnum;

class DepositChannel extends LocalEnum
{
    const MOMO = 1;
    const PHONE_CARD = 2;
    const TRANSFER_BANK = 3;
}
