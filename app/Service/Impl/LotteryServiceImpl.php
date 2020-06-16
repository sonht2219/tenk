<?php


namespace App\Service\Impl;


use App\Models\Lottery;
use App\Models\LotterySession;
use App\Models\Product;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Criteria\Lottery\HasLotterySessionIdCriteria;
use App\Repositories\Criteria\Lottery\LotterySearchCriteria;
use App\Service\Contract\LotteryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LotteryServiceImpl implements LotteryService
{
    private LotteryRepository $lotteryRepo;

    public function __construct(LotteryRepository $lotteryRepo)
    {
        $this->lotteryRepo = $lotteryRepo;
    }

    public function syncLotteryForSession(LotterySession $session)
    {
        $newLotteryCount = $session->product->price;
        for ($i = 0; $i < $newLotteryCount; $i++) {
            $newLottery = new Lottery();
            $newLottery->session()->associate($session);
            $newLottery->serial = $i;
            $this->lotteryRepo->save($newLottery);
        }
    }

    public function listLotteries($id, $search, $limit = 10): LengthAwarePaginator
    {
        $this->lotteryRepo->pushCriteria(new HasLotterySessionIdCriteria($id));

        if ($search)
            $this->lotteryRepo->pushCriteria(new LotterySearchCriteria($search));

        return $this->lotteryRepo->paginate($limit);
    }

    public function buyLotteries($session_id, $lottery_ids)
    {
    }

}
