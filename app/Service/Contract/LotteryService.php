<?php


namespace App\Service\Contract;


use App\Http\Requests\BuyLotteryRequest;
use App\Models\Bot;
use App\Models\LotterySession;
use App\Models\Product;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface LotteryService
{
    public function syncLotteryForSession(LotterySession $session);
    public function listLotteries($id, $search, $limit): LengthAwarePaginator;

    /**
     * @param User $user
     * @param BuyLotteryRequest $req
     * @param Bot|null $bot
     * @return mixed
     */
    public function buyLotteries($user, BuyLotteryRequest $req, $bot = null);
    public function allLotteriesOfUserInLotterySession($session_id, $user_id);
    public function getUnitPriceLottery();
    public function countSoldLottery();
    public function getHistoryBuyLotteryOfSession($session_id, $user_id);
    public function statisticByDay($from, $to);
    public function statisticTopUser($from, $to, $limit);
}
