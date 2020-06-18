<?php


namespace App\Service\Impl;


use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Exceptions\ExecuteException;
use App\Models\Lottery;
use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionStartCountDown;
use App\Queue\Jobs\CalculateRewardForLotterySession;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Criteria\Lottery\HasLotterySessionIdCriteria;
use App\Repositories\Criteria\Lottery\HasUserIdCriteria;
use App\Repositories\Criteria\Lottery\LotterySearchCriteria;
use App\Service\Contract\LotteryService;
use App\Service\Traits\CanUseWallet;
use App\Service\Traits\CreateSessionTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LotteryServiceImpl implements LotteryService
{
    use CanUseWallet, CreateSessionTrait;
    private LotteryRepository $lotteryRepo;
    private LotterySessionRepository $lotterySessionRepo;

    public function __construct(LotteryRepository $lotteryRepo, LotterySessionRepository $lotterySessionRepo)
    {
        $this->lotteryRepo = $lotteryRepo;
        $this->lotterySessionRepo = $lotterySessionRepo;
    }

    public function syncLotteryForSession(LotterySession $session)
    {
        $newLotteryCount = $session->product->price;
        for ($i = 0; $i < $newLotteryCount; $i++) {
            $newLottery = new Lottery();
            $newLottery->session()->associate($session);
            $newLottery->serial = $i;
            $this->lotteryRepo->save($newLottery);
        }
    }

    public function listLotteries($id, $search, $limit = 10): LengthAwarePaginator
    {
        $this->lotteryRepo->pushCriteria(new HasLotterySessionIdCriteria($id));

        if ($search)
            $this->lotteryRepo->pushCriteria(new LotterySearchCriteria($search));

        return $this->lotteryRepo->paginate($limit);
    }

    public function allLotteriesOfUserInLotterySession($session_id, $user_id)
    {
        $this->lotteryRepo->pushCriteria(new HasLotterySessionIdCriteria($session_id));
        $this->lotteryRepo->pushCriteria(new HasUserIdCriteria($user_id));
        return $this->lotteryRepo->all();
    }

    public function buyLotteries($session_id, $lottery_ids)
    {
        $now = round(microtime(true) * 1000);
        /** @var User $user */
        $user = Auth::user();
        /** @var LotterySession $lottery_session */
        $lottery_session = $this->lotterySessionRepo->findByIdWithRelations($session_id, ['product']);
        if ($lottery_session->status != LotterySessionStatus::SELLING)
            throw new ExecuteException(__('Đợt tham gia này đã kết thúc bán phiếu'));

        $lotteries = $this->lotteryRepo->findWhereIn('id', $lottery_ids);
        if (count($invalids = $this->findInvalidLotteries($lotteries, $lottery_session)))
            throw new ExecuteException(__('Phiếu ' . implode(', ', $invalids) . ' không hợp lệ. Vui lòng chọn phiếu khác'));

        $amount_lotteries = count($lotteries);
        $sold_quantity = $lottery_session->sold_quantity += $amount_lotteries;
        if ($sold_quantity > $lottery_session->product->price)
            throw new ExecuteException(__('Số lượng phiếu không đủ'));

        $total_price = $amount_lotteries * $this->getUnitPriceLottery();
        $this->changeCashOfUser($user, -$total_price, 'Mua phiếu dự thưởng');

        $this->lotteryRepo->updateLotteries($lottery_ids, [
            'user_id' => $user->id,
            'joined_at' => $now,
            'status' => LotteryStatus::SOLD
        ]);

        $lottery_session->update(['sold_quantity' => $sold_quantity]);

        if ($sold_quantity == $lottery_session->product->price) {
            $this->countDownLotterySession($lottery_session, $now);
            $this->createLotterySession($lottery_session->product);
            dispatch(new CalculateRewardForLotterySession($lottery_session))
                ->delay(Carbon::now()->addMilliseconds($this->getTimeCountDown()));
            event(new LotterySessionStartCountDown($lottery_session));
        }

        return ['data' => true];
    }

    /**
     * @param LotterySession $lottery_session
     * @param $now
     */
    public function countDownLotterySession($lottery_session, $now) {
        $this->lotterySessionRepo->update(
            [
                'time_end' => $now + $this->getTimeCountDown(),
                'status' => LotterySessionStatus::COUNT_DOWNING
            ],
            $lottery_session->id
        );
    }

    /**
     * @param $lotteries
     * @param LotterySession $session
     * @return int[]
     */
    public function findInvalidLotteries($lotteries, $session) {
        $invalid_lotteries = [];
        foreach ($lotteries as $lottery) {
            if ($lottery->status != LotteryStatus::WAITING || $lottery->session_id != $session->id)
                $invalid_lotteries[] = $lottery->serial;
        }
        return $invalid_lotteries;
    }

    public function getUnitPriceLottery() {
        return 10;
    }

    public function getTimeCountDown() {
        return 3 * 60 * 1000 - 1000;
    }

}
