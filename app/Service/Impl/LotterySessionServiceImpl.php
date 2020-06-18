<?php


namespace App\Service\Impl;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionSaved;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Lottery\HasLotterySessionIdCriteria;
use App\Repositories\Criteria\Lottery\LotterySearchCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionSearchCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithProductCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithRelationCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithRewardCriteria;
use App\Service\Contract\LotterySessionService;
use App\Service\Traits\CreateSessionTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LotterySessionServiceImpl implements LotterySessionService
{
    use CreateSessionTrait;
    private LotterySessionRepository $lotterySessionRepo;
    private ProductRepository $productRepo;
    private LotteryRepository $lotteryRepo;

    public function __construct(LotterySessionRepository $lotterySessionRepo, ProductRepository $productRepo, LotteryRepository $lotteryRepo)
    {
        $this->lotterySessionRepo = $lotterySessionRepo;
        $this->productRepo = $productRepo;
        $this->lotteryRepo = $lotteryRepo;
    }

    public function single($id): LotterySession
    {
        $this->lotterySessionRepo->pushCriteria(LotterySessionWithProductCriteria::class);
        /** @var LotterySession $session */
        $session = $this->lotterySessionRepo->find($id);
        if ($session->status == LotterySessionStatus::ENDING) {
            $session->load('reward', 'reward.user', 'reward.lottery');
        }
        return $session;
    }

    public function historyLotterySession($session_id, $limit): LengthAwarePaginator
    {
        return $this->lotteryRepo->historyLotterySession($session_id, $limit);
    }

    public function list($limit, $search, $status = LotterySessionStatus::SELLING): LengthAwarePaginator
    {
        if ($search)
            $this->lotterySessionRepo->pushCriteria(new LotterySessionSearchCriteria($search));

        if ($status)
            $this->lotterySessionRepo->pushCriteria(new HasStatusCriteria($status));

        $this->lotterySessionRepo->pushCriteria(LotterySessionWithRelationCriteria::class);

        return $this->lotterySessionRepo->paginate($limit);

    }

    public function listSessionOpeningAndEnded($limit): LengthAwarePaginator
    {
        return $this->lotterySessionRepo->listSessionOpeningAndEnded($limit);
    }
}
