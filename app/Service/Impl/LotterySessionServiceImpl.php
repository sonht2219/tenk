<?php


namespace App\Service\Impl;


use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionSaved;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Service\Contract\LotterySessionService;

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
}
