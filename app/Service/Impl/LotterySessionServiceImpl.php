<?php


namespace App\Service\Impl;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Criteria\Common\HasFromCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\HasToCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Repositories\Criteria\Lottery\LotteryHasJoinedAtFromCriteria;
use App\Repositories\Criteria\Lottery\LotteryHasJoinedAtToCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionHasProductIdCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionSearchCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionStatisticByDayCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionStatisticTopProductCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithProductCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithRelationCriteria;
use App\Service\Contract\LotterySessionService;
use App\Service\Traits\CreateSessionTrait;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

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

    public function singleByProductAndStatus($product_id, $status = LotterySessionStatus::SELLING)
    {
        $this->lotterySessionRepo->pushCriteria(new LotterySessionHasProductIdCriteria($product_id));
        $this->lotterySessionRepo->pushCriteria(new HasStatusCriteria($status));
        $this->lotterySessionRepo->pushCriteria(LotterySessionWithProductCriteria::class);

        return $this->lotterySessionRepo->firstOrFail();
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

    public function historyMine(Request $req, User $user): LengthAwarePaginator
    {
        $limit = $req->get('limit') ?: 10;
        $status_str = $req->get('status');
        if ($status_str)
            $statuses = explode(',', $status_str);
        else
            $statuses = LotterySessionStatus::getValues();

        return $this->lotterySessionRepo->listSessionOfUserByStatus($user->id, $statuses, $limit);
    }

    public function countByStatus($status)
    {
        if (is_numeric($status)) {
            $this->lotterySessionRepo->pushCriteria(new HasStatusCriteria($status));
        }

        return $this->lotterySessionRepo->count();
    }

    public function userJoinedSession($session_id, $user_id): bool
    {
        return $this->lotterySessionRepo->userJoinedSession($session_id, $user_id);
    }

    public function statisticSessionByDay($from, $to)
    {
        if ($from)
            $this->lotterySessionRepo->pushCriteria(new HasFromCriteria($from));
        if ($to)
            $this->lotterySessionRepo->pushCriteria(new HasToCriteria($to));

        $this->lotterySessionRepo->pushCriteria(LotterySessionStatisticByDayCriteria::class);

        return $this->lotterySessionRepo->all();
    }

    public function statisticTopProduct($from, $to, $limit)
    {
        if ($from)
            $this->lotterySessionRepo->pushCriteria(new HasFromCriteria($from));
        if ($to)
            $this->lotterySessionRepo->pushCriteria(new HasToCriteria($to));

        $this->lotterySessionRepo->pushCriteria(new LotterySessionStatisticTopProductCriteria($limit));
        $this->lotterySessionRepo->pushCriteria(new WithRelationsCriteria('product'));

        return $this->lotterySessionRepo->all();
    }
}
