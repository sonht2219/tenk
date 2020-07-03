<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\BuyLotteryRequest;
use App\Models\Lottery;
use App\Models\LotterySession;
use App\Models\Product;
use App\Queue\Events\LotterySessionStartCountDown;
use App\Queue\Jobs\CalculateRewardForLotterySession;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Repositories\Criteria\Common\HasFromCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\HasToCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Repositories\Criteria\Lottery\LotteryHasJoinedAtFromCriteria;
use App\Repositories\Criteria\Lottery\LotteryHasJoinedAtToCriteria;
use App\Repositories\Criteria\Lottery\LotteryHasLotterySessionIdCriteria;
use App\Repositories\Criteria\Lottery\LotteryHasUserIdNotNullCriteria;
use App\Repositories\Criteria\Lottery\LotterySearchCriteria;
use App\Repositories\Criteria\Lottery\LotteryStatisticByDayCriteria;
use App\Repositories\Criteria\Lottery\LotteryStatisticTopUserCriteria;
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
        $newLotteryCount = $session->price;
        for ($i = 0; $i < $newLotteryCount; $i++) {
            $newLottery = new Lottery();
            $newLottery->session()->associate($session);
            $newLottery->serial = $i;
            $this->lotteryRepo->save($newLottery);
        }
    }

    public function listLotteries($id, $search, $limit = 10): LengthAwarePaginator
    {
        $this->lotteryRepo->pushCriteria(new LotteryHasLotterySessionIdCriteria($id));

        if ($search)
            $this->lotteryRepo->pushCriteria(new LotterySearchCriteria($search));

        return $this->lotteryRepo->paginate($limit);
    }

    public function allLotteriesOfUserInLotterySession($session_id, $user_id)
    {
        $this->lotteryRepo->pushCriteria(new LotteryHasLotterySessionIdCriteria($session_id));
        $this->lotteryRepo->pushCriteria(new BelongToUserCriteria($user_id));
        return $this->lotteryRepo->all();
    }

    public function getHistoryBuyLotteryOfSession($session_id, $user_id)
    {
        return $this->lotteryRepo->findHistoryBuyLottery($session_id, $user_id);
    }

    public function buyLotteries(BuyLotteryRequest $req)
    {
        $now = round(microtime(true) * 1000);
        /** @var User $user */
        $user = Auth::user();
        /** @var LotterySession $lottery_session */
        $lottery_session = $this->lotterySessionRepo->findByIdWithRelations($req->get('session_id'), ['product']);
        if ($lottery_session->status != LotterySessionStatus::SELLING)
            throw new ExecuteException(__('Đợt tham gia này đã kết thúc bán phiếu'));

        $choose_lottery = $req->get('choose_lottery');
        if ($choose_lottery) {
            $lottery_ids = $req->get('lottery_ids');
            $lotteries = $this->lotteryRepo->findWhereIn('id', $lottery_ids);
            if (count($invalids = $this->findInvalidLotteries($lotteries, $lottery_session)))
                throw new ExecuteException(__('Phiếu ' . implode(', ', $invalids) . ' không hợp lệ. Vui lòng chọn phiếu khác'));
        } else {
            $lottery_quantity = $req->get('lottery_quantity');
            if ($lottery_session->sold_quantity + $lottery_quantity > $lottery_session->price)
                throw new ExecuteException('Số lượng phiếu không đủ');
            $lotteries = $this->lotteryRepo->randomLotteries($lottery_session->id, $lottery_quantity);
            if (!$lotteries || !count($lotteries))
                throw new ExecuteException(__('Hiện tại không có phiếu, vui lòng quay lại sau'));
            $lottery_ids = $lotteries->map(fn($lottery) => $lottery->id)->toArray();
        }

        $amount_lotteries = count($lotteries);
        $sold_quantity = $lottery_session->sold_quantity += $amount_lotteries;
        if ($sold_quantity > $lottery_session->price)
            throw new ExecuteException(__('Số lượng phiếu không đủ'));

        $total_price = $amount_lotteries * $this->getUnitPriceLottery();
        $this->changeCashOfUser($user, -$total_price, 'Mua phiếu dự thưởng');

        $this->lotteryRepo->updateLotteries($lottery_ids, [
            'user_id' => $user->id,
            'joined_at' => $now,
            'status' => LotteryStatus::SOLD
        ]);

        $lottery_session->update(['sold_quantity' => $sold_quantity]);

        if ($sold_quantity == $lottery_session->price && $lottery_session->product->status == CommonStatus::ACTIVE) {
            $delay = $this->getTimeCountDown() - 2 * 1000;
            $this->countDownLotterySession($lottery_session, $now);
            $this->createLotterySession($lottery_session->product);
            dispatch(new CalculateRewardForLotterySession($lottery_session))
                ->delay(Carbon::now()->addMilliseconds($delay));
            event(new LotterySessionStartCountDown($lottery_session));
        }

        return $this->lotteryRepo->findWhereIn('id', $lottery_ids);
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
        return 3 * 60 * 1000;
    }

    public function countSoldLottery()
    {
        $this->lotteryRepo->pushCriteria(new HasStatusCriteria(LotteryStatus::SOLD));
        return $this->lotteryRepo->count();
    }

    public function statisticByDay($from, $to)
    {
        if ($from)
            $this->lotteryRepo->pushCriteria(new LotteryHasJoinedAtFromCriteria($from));
        if ($to)
            $this->lotteryRepo->pushCriteria(new LotteryHasJoinedAtToCriteria($to));

        $this->lotteryRepo->pushCriteria(LotteryHasUserIdNotNullCriteria::class);
        $this->lotteryRepo->pushCriteria(LotteryStatisticByDayCriteria::class);

        return $this->lotteryRepo->all();
    }

    public function statisticTopUser($from, $to)
    {
        if ($from)
            $this->lotteryRepo->pushCriteria(new HasFromCriteria($from));
        if ($to)
            $this->lotteryRepo->pushCriteria(new HasToCriteria($to));

        $this->lotteryRepo->pushCriteria(LotteryHasUserIdNotNullCriteria::class);
        $this->lotteryRepo->pushCriteria(LotteryStatisticTopUserCriteria::class);
        $this->lotteryRepo->pushCriteria(new WithRelationsCriteria('user'));

        return $this->lotteryRepo->all();
    }
}
