<?php


namespace App\Enum\Status;


use App\Enum\Contract\LocalEnum;

class CommonStatus extends LocalEnum
{
    const ACTIVE = 1;
    const INACTIVE = -1;
}
