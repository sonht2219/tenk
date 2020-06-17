<?php


namespace App\Queue\Listeners;


use App\Queue\Events\ProductSaved;
use App\Service\Contract\LotterySessionService;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class StartSessionForProduct implements ShouldQueue
{
    private LotterySessionService $lotterySessionService;

    public function __construct(LotterySessionService $lotterySessionService)
    {

        $this->lotterySessionService = $lotterySessionService;
    }

    public function handle(ProductSaved $event)
    {
        if ($event->will_start_session) {
            try {
                DB::beginTransaction();
                $this->lotterySessionService->createLotterySession($event->product);
                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
