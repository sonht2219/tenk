<?php


namespace App\Service\Impl;


use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionSaved;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Criteria\Lottery\HasLotterySessionIdCriteria;
use App\Repositories\Criteria\Lottery\LotterySearchCriteria;
use App\Repositories\Criteria\LotterySession\LotterySessionWithProductCriteria;
use App\Service\Contract\LotterySessionService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LotterySessionServiceImpl implements LotterySessionService
{
    private LotterySessionRepository $lotterySessionRepo;
    private ProductRepository $productRepo;
    private LotteryRepository $lotteryRepo;

    public function __construct(LotterySessionRepository $lotterySessionRepo, ProductRepository $productRepo, LotteryRepository $lotteryRepo)
    {
        $this->lotterySessionRepo = $lotterySessionRepo;
        $this->productRepo = $productRepo;
        $this->lotteryRepo = $lotteryRepo;
    }

    public function create(Product $product)
    {
        $session = new LotterySession();
        $session->product()->associate($product);

        $session = $this->lotterySessionRepo->save($session);

        event(new LotterySessionSaved($session));

        return $session;
    }

    public function single($id): LotterySession
    {
        $this->lotterySessionRepo->pushCriteria(LotterySessionWithProductCriteria::class);
        return $this->lotterySessionRepo->find($id);
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
