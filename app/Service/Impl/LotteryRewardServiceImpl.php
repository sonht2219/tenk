<?php


namespace App\Service\Impl;


use App\Models\LotteryReward;
use App\Models\LotterySession;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotteryRewardRepository;
use App\Service\Contract\LotteryRewardService;
use App\Service\Helper\Lottery\LotteryWinnerRetriever;
use App\Service\Helper\Lottery\LotteryWinnerRetrieverFactory;
use App\Service\Helper\Lottery\LotteryWinnerRetrieverType;

class LotteryRewardServiceImpl implements LotteryRewardService
{
    private LotteryRewardRepository $rewardRepo;
    private LotteryRepository $lotteryRepo;

    public function __construct(LotteryRewardRepository $rewardRepo, LotteryRepository $lotteryRepo)
    {
        $this->rewardRepo = $rewardRepo;
        $this->lotteryRepo = $lotteryRepo;
    }

    public function create(LotterySession $session)
    {
        $winnerRetriever = $this->getRetriever();

        $winner = $winnerRetriever->retrieveWinner($session);

        $reward = new LotteryReward();
        $reward->session()->associate($session);
        $reward->user()->associate($winner->user);
        $reward->lottery()->associate($winner);
        $reward->join_times = $this->lotteryRepo->countJoinTimesOfUserInSession($winner->user_id, $session->id);

        return $this->rewardRepo->save($reward);
    }

    private function getRetriever(): LotteryWinnerRetriever {
        return LotteryWinnerRetrieverFactory::getRetriever(LotteryWinnerRetrieverType::MOCK);
    }
}
