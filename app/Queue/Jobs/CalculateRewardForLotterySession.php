<?php


namespace App\Queue\Jobs;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Repositories\Contract\LotterySessionRepository;
use App\Service\Contract\LotteryRewardService;
use DB;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateRewardForLotterySession implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private LotterySession $session;

    public function __construct(LotterySession $session)
    {
        $this->session = $session;
    }

    public function handle(LotteryRewardService $rewardService, LotterySessionRepository $lotterySessionRepo) {
        DB::beginTransaction();
        try {
            $session = $this->session;
            $rewardService->create($session);
            $session->status = LotterySessionStatus::ENDING;
            $lotterySessionRepo->save($session);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
