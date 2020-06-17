<?php


namespace App\Enum\Status;


use App\Enum\Contract\LocalEnum;

class RewardStatus extends LocalEnum
{
    const PROCESSING = 1;
    const SHIPPING = 2;
    const DONE = 3;
    const REJECTED = -1;
}
