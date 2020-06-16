<?php


namespace App\Service\Impl;


use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Exceptions\ExecuteException;
use App\Models\Lottery;
use App\Models\LotterySession;
use App\Models\Product;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Criteria\Lottery\HasLotterySessionIdCriteria;
use App\Repositories\Criteria\Lottery\LotterySearchCriteria;
use App\Service\Contract\LotteryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LotteryServiceImpl implements LotteryService
{
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

    public function buyLotteries($session_id, $lottery_ids)
    {
        $user = Auth::user();
        /** @var LotterySession $lottery_session */
        $lottery_session = $this->lotterySessionRepo->find($session_id);
        if ($lottery_session->status != LotterySessionStatus::SELLING)
            throw new ExecuteException(__('Đợt tham gia này đã kết thúc bán phiếu'));

        $lotteries = $this->lotteryRepo->findWhereIn('id', $lottery_ids);
        if (count($invalids = $this->findInvalidLotteries($lotteries)))
            throw new ExecuteException(__('Phiếu ' . implode(', ', $invalids) . ' không hợp lệ. Vui lòng chọn phiếu khác'));
        
        $amount_lotteries = count($lotteries);
        $total_price = $amount_lotteries * $this->getUnitPriceLottery();
        //check and update wallet user

        $this->lotteryRepo->updateLotteries($lottery_ids, [
            'user_id' => $user->id,
            'status' => LotteryStatus::SOLD
        ]);

        $lottery_session->update(['sold_quantity' => $lottery_session->sold_quantity += $amount_lotteries]);

        return $lotteries;
    }

    /**
     * @param $lotteries
     * @return int[]
     */
    public function findInvalidLotteries($lotteries) {
        $invalid_lotteries = [];
        foreach ($lotteries as $lottery) {
            if ($lottery->status != LotteryStatus::WAITING)
                $invalid_lotteries[] = $lottery->serial;
        }
        return $invalid_lotteries;
    }

    public function getUnitPriceLottery() {
        return 10;
    }

}
