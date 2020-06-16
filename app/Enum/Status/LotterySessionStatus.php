<?php


namespace App\Enum\Status;


use App\Enum\Contract\LocalEnum;

class LotterySessionStatus extends LocalEnum
{
    const SELLING = 1;
    const COUNT_DOWNING = 2;
    const ENDING = 3;
    const DELETED = -1;
}
