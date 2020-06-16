<?php


namespace App\Service\Contract;


use App\Models\LotterySession;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LotteryService
{
    public function syncLotteryForSession(LotterySession $session);
    public function listLotteries($id, $search, $limit): LengthAwarePaginator;
    public function buyLotteries($session_id, $lottery_ids);
}
