<?php


namespace App\Service\Impl;


use App\Models\LotteryReward;
use App\Models\LotterySession;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotteryRewardRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Criteria\Common\OrderByCreatedAtDescCriteria;
use App\Repositories\Criteria\LotteryReward\BelongToSessionHasProductIdCriteria;
use App\Repositories\Criteria\LotteryReward\LotteryRewardWithRelationsCriteria;
use App\Service\Contract\LotteryRewardService;
use App\Service\Helper\Lottery\LotteryWinnerRetriever;
use App\Service\Helper\Lottery\LotteryWinnerRetrieverFactory;
use App\Service\Helper\Lottery\LotteryWinnerRetrieverType;
use Illuminate\Pagination\LengthAwarePaginator;

class LotteryRewardServiceImpl implements LotteryRewardService
{
    private LotteryRewardRepository $rewardRepo;
    private LotteryRepository $lotteryRepo;
    private LotterySessionRepository $lotterySessionRepo;

    public function __construct(LotteryRewardRepository $rewardRepo, LotteryRepository $lotteryRepo, LotterySessionRepository $lotterySessionRepo)
    {
        $this->rewardRepo = $rewardRepo;
        $this->lotteryRepo = $lotteryRepo;
        $this->lotterySessionRepo = $lotterySessionRepo;
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

    public function listRewardOfProduct($product_id, $limit): LengthAwarePaginator
    {
        $this->rewardRepo->pushCriteria(new BelongToSessionHasProductIdCriteria($product_id));
        $this->rewardRepo->pushCriteria(LotteryRewardWithRelationsCriteria::class);
        $this->rewardRepo->pushCriteria(OrderByCreatedAtDescCriteria::class);

        return $this->rewardRepo->paginate($limit);
    }

    private function getRetriever(): LotteryWinnerRetriever {
        return LotteryWinnerRetrieverFactory::getRetriever(LotteryWinnerRetrieverType::MOCK);
    }
}
