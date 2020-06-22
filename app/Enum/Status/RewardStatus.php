<?php


namespace App\Enum\Status;


use App\Enum\Contract\LocalEnum;

class RewardStatus extends LocalEnum
{
    const WAITING = 1;
    const PROCESSING = 2;
    const SHIPPING = 3;
    const DONE = 4;
    const REJECTED = -1;
}
