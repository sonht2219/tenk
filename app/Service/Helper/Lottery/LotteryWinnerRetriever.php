<?php


namespace App\Service\Helper\Lottery;


use App\Models\Lottery;
use App\Models\LotterySession;

interface LotteryWinnerRetriever
{
    public function retrieveWinner(LotterySession $session): Lottery;
}
