<?php


namespace App\Service\Contract;


use App\Models\LotterySession;
use App\Models\Product;

interface LotteryService
{
    public function syncLotteryForSession(LotterySession $session);
}
