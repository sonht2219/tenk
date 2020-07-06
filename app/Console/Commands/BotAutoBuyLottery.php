<?php

namespace App\Console\Commands;

use App\Http\Requests\BuyLotteryRequest;
use App\Models\Bot;
use App\Models\LotterySession;
use App\Service\Contract\BotService;
use App\Service\Contract\LotteryService;
use App\Service\Contract\LotterySessionService;
use App\Service\Contract\UserService;
use App\User;
use DB;
use Exception;
use Illuminate\Console\Command;
use Log;

class BotAutoBuyLottery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:buy-lottery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bot will auto buy the lottery';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(LotteryService $lotteryService, BotService $botService, LotterySessionService $sessionService)
    {
        $limit = $this->getLimitEachAutoBuy();
        $allowed_percent_lottery_each_times = $this->getAllowedPercentLottery();

        $bots = $botService->findRandomBots($limit);
        $sessions = $sessionService->findRandomSessions($limit);

        $max_index = count($bots) < count($sessions) ? count($bots) : count($sessions);

        for ($i = 0; $i < $max_index; $i++) {
            /**
             * @var Bot $bot
             * @var User $user
             * @var LotterySession $session
             */
            $bot = $bots[$i];
            $user = $bot->user;
            $session = $sessions[$i];

            $remain = $session->price - $session->sold_quantity;
            if ($session->price / $remain > $allowed_percent_lottery_each_times) continue;

            $allowed_lottery_quantity = round($session->price * $allowed_percent_lottery_each_times / 100, 0, PHP_ROUND_HALF_DOWN);
            if ($allowed_lottery_quantity > $bot->limit_per_buy)
                $allowed_lottery_quantity = $bot->limit_per_buy;

            $request = BuyLotteryRequest::create('', 'POST', [
                'session_id' => $session->id,
                'lottery_quantity' => $allowed_lottery_quantity
            ]);
            try {
                DB::beginTransaction();
                $lotteryService->buyLotteries($user, $request, $bot);
                DB::commit();
                $this->info(
                    'Bot '
                    . $user->phone_number
                    . ' (' . $user->id . ')'
                    . ' đã mua '
                    . $allowed_lottery_quantity
                    . ' vé từ phiên '
                    . $session->id
                );
            } catch (Exception $e) {
                DB::rollBack();
                Log::error($e);
                $this->error(
                    'Bot '
                    . $user->phone_number
                    . ' (' . $user->id . ')'
                    . ' mua thất bại '
                    . $allowed_lottery_quantity
                    . ' vé từ phiên '
                    . $session->id
                    . '. Lý do: '
                    . $e->getMessage()
                );
            }
        }
    }

    private function getLimitEachAutoBuy()
    {
        return 100;
    }

    private function getAllowedPercentLottery() {
        return 10;
    }
}
