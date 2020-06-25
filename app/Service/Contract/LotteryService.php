<?php


namespace App\Service\Contract;


use App\Http\Requests\BuyLotteryRequest;
use App\Models\LotterySession;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LotteryService
{
    public function syncLotteryForSession(LotterySession $session);
    public function listLotteries($id, $search, $limit): LengthAwarePaginator;
    public function buyLotteries(BuyLotteryRequest $req);
    public function allLotteriesOfUserInLotterySession($session_id, $user_id);
    public function getUnitPriceLottery();
    public function countSoldLottery();
    public function getHistoryBuyLotteryOfSession($session_id, $user_id);
}
