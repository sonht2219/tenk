<?php


namespace App\Service\Helper\Lottery;


use App\Models\Lottery;
use App\Models\LotterySession;

class LotteryWinnerByTimesRetriever implements LotteryWinnerRetriever
{
    public function retrieveWinner(LotterySession $session): Lottery
    {
        // TODO: Implement retrieveWinner() method.
    }
}
