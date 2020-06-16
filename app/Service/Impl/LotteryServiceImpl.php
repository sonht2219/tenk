<?php


namespace App\Service\Impl;


use App\Models\Lottery;
use App\Models\LotterySession;
use App\Models\Product;
use App\Repositories\Contract\LotteryRepository;
use App\Service\Contract\LotteryService;

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

}
