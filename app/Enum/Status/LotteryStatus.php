<?php


namespace App\Enum\Status;


use App\Enum\Contract\LocalEnum;

class LotteryStatus extends LocalEnum
{
    const WAITING = 1;
    const SOLD = 2;
    const DISABLED = -1;
}
