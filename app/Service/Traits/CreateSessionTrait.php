<?php


namespace App\Service\Traits;


use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionSaved;
use App\Repositories\Contract\LotterySessionRepository;

trait CreateSessionTrait
{
    private bool $is_initialize = false;
    private LotterySessionRepository $lotterySessionRepo;

    public function createLotterySession(Product $product)
    {
        $this->initializeCreateSession();
        $session = new LotterySession();
        $session->product()->associate($product);

        $session = $this->lotterySessionRepo->save($session);

        event(new LotterySessionSaved($session));

        return $session;
    }

    private function initializeCreateSession() {
        if (!$this->is_initialize) {
            $this->lotterySessionRepo = app(LotterySessionRepository::class);
            $this->is_initialize = true;
        }
    }
}
