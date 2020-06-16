<?php


namespace App\Service\Impl;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionSaved;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionSearchCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithRelationCriteria;
use App\Service\Contract\LotterySessionService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LotterySessionServiceImpl implements LotterySessionService
{
    private LotterySessionRepository $lotterySessionRepo;
    private ProductRepository $productRepo;

    public function __construct(LotterySessionRepository $lotterySessionRepo, ProductRepository $productRepo)
    {
        $this->lotterySessionRepo = $lotterySessionRepo;
        $this->productRepo = $productRepo;
    }

    public function create(Product $product)
    {
        $session = new LotterySession();
        $session->product()->associate($product);

        $session = $this->lotterySessionRepo->save($session);

        event(new LotterySessionSaved($session));

        return $session;
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
}
