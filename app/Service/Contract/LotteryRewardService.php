<?php


namespace App\Service\Contract;


use App\Models\LotterySession;

interface LotteryRewardService
{
    public function create(LotterySession $session);
}
