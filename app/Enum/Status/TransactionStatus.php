<?php


namespace App\Enum\Status;


use App\Enum\Contract\LocalEnum;

class TransactionStatus extends LocalEnum
{
    const PENDING = 2;
    const SUCCESS = 1;
    const REJECT = -1;
}
