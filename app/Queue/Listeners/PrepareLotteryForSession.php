<?php


namespace App\Queue\Listeners;


use App\Queue\Events\LotterySessionSaved;
use App\Service\Contract\LotteryService;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrepareLotteryForSession implements ShouldQueue
{
    public $delay = 2;
    /**
     * @var LotteryService
     */
    private LotteryService $lotteryService;

    public function __construct(LotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    public function handle(LotterySessionSaved $event)
    {
        $this->lotteryService->syncLotteryForSession($event->session);
    }
}
