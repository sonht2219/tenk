<?php


namespace App\Service\Helper\Lottery;


use App\Models\Lottery;
use App\Models\LotterySession;
use App\Repositories\Contract\LotteryRepository;

class LotteryWinnerMockRetriever implements LotteryWinnerRetriever
{
    public function retrieveWinner(LotterySession $session): Lottery
    {
        return Lottery::query()
            ->where('session_id', $session->id)
            ->orderBy('joined_at', 'desc')
            ->first();
    }
}
