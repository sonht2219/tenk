<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\RewardStatus;
use App\Exceptions\ExecuteException;
use App\Http\Requests\ReceiveRewardRequest;
use App\Models\LotteryReward;
use App\Models\LotteryRewardInfo;
use App\Models\LotterySession;
use App\Models\UserAddress;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotteryRewardInfoRepository;
use App\Repositories\Contract\LotteryRewardRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\UserAddressRepository;
use App\Repositories\Criteria\Common\BelongToUserCriteria;
use App\Repositories\Criteria\Common\HasStatusCriteria;
use App\Repositories\Criteria\Common\OrderByCreatedAtDescCriteria;
use App\Repositories\Criteria\Common\WithRelationsCriteria;
use App\Repositories\Criteria\LotteryReward\LotteryRewardBelongToSessionHasProductIdCriteria;
//use App\Repositories\Criteria\LotteryReward\HasUserIdCriteria;
use App\Repositories\Criteria\LotteryReward\LotteryRewardHasInfoCriteria;
use App\Repositories\Criteria\LotteryReward\LotteryRewardWithRelationsCriteria;
use App\Service\Contract\LotteryRewardService;
use App\Service\Helper\Lottery\LotteryWinnerRetriever;
use App\Service\Helper\Lottery\LotteryWinnerRetrieverFactory;
use App\Service\Helper\Lottery\LotteryWinnerRetrieverType;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class LotteryRewardServiceImpl implements LotteryRewardService
{
    private LotteryRewardRepository $rewardRepo;
    private LotteryRepository $lotteryRepo;
    private LotterySessionRepository $lotterySessionRepo;
    private UserAddressRepository $userAddressRepo;
    private LotteryRewardInfoRepository $rewardInfoRepo;
    public function __construct(
        LotteryRewardRepository $rewardRepo,
        LotteryRepository $lotteryRepo,
        LotterySessionRepository $lotterySessionRepo,
        UserAddressRepository $userAddressRepo,
        LotteryRewardInfoRepository $rewardInfoRepo
    )
    {
        $this->rewardRepo = $rewardRepo;
        $this->lotteryRepo = $lotteryRepo;
        $this->lotterySessionRepo = $lotterySessionRepo;
        $this->userAddressRepo = $userAddressRepo;
        $this->rewardInfoRepo = $rewardInfoRepo;
    }

    public function create(LotterySession $session): LotteryReward
    {
        $winnerRetriever = $this->getRetriever();

        $winner = $winnerRetriever->retrieveWinner($session);

        $reward = new LotteryReward();
        $reward->session()->associate($session);
        $reward->user()->associate($winner->user);
        $reward->lottery()->associate($winner);
        $reward->join_times = $this->lotteryRepo->countJoinTimesOfUserInSession($winner->user_id, $session->id);

        return $this->rewardRepo->save($reward);
    }

    public function listRewardOfProduct($product_id, $limit): LengthAwarePaginator
    {
        $this->rewardRepo->pushCriteria(new LotteryRewardBelongToSessionHasProductIdCriteria($product_id));
        $this->rewardRepo->pushCriteria(LotteryRewardWithRelationsCriteria::class);
        $this->rewardRepo->pushCriteria(OrderByCreatedAtDescCriteria::class);

        return $this->rewardRepo->paginate($limit);
    }

    private function getRetriever(): LotteryWinnerRetriever {
        return LotteryWinnerRetrieverFactory::getRetriever(LotteryWinnerRetrieverType::MOCK);
    }

    public function history(Request $req, User $user): LengthAwarePaginator
    {
        $status = $req->get('status') ?: RewardStatus::WAITING;
        $limit = $req->get('limit') ?: 10;
        $this->rewardRepo->pushCriteria(new BelongToUserCriteria($user->id));
        $this->rewardRepo->pushCriteria(new HasStatusCriteria($status));
        $this->rewardRepo->pushCriteria(LotteryRewardWithRelationsCriteria::class);

        return $this->rewardRepo->paginate($limit);
    }

    public function receiveReward(ReceiveRewardRequest $req, User $user)
    {
        /** @var LotteryReward $reward */
        $reward = $this->rewardRepo->find($req->get('reward_id'));
        if ($reward->user_id != $user->id)
            throw new ExecuteException(__('Phần thưởng không hợp lệ'));
        if ($reward->status != RewardStatus::WAITING)
            throw new ExecuteException(__('Phần thưởng đã được xử lý'));

        /** @var UserAddress $user_address */
        $user_address = $this->userAddressRepo->find($req->get('user_address_id'));
        if ($user_address->user_id != $user->id || $user_address->status != CommonStatus::ACTIVE)
            throw new ExecuteException(__('Địa chỉ này không hợp lệ'));

        $reward->update(['status' => RewardStatus::PROCESSING]);

        $reward_info = $this->retrieveRewardInfo($reward->id);
        $reward_info->reward()->associate($reward);
        $reward_info->name = $user_address->name;
        $reward_info->phone_number = $user_address->phone_number;
        $reward_info->address = $user_address->address;
        $reward_info->province_id = $user_address->province_id;
        $reward_info->district_id = $user_address->district_id;
        $this->rewardInfoRepo->save($reward_info);

        return $reward;
    }

    /**
     * @param $reward_id
     * @return LotteryRewardInfo
     */
    private function retrieveRewardInfo($reward_id) {
        $reward_info = $this->rewardInfoRepo->findByRewardId($reward_id);
        if (!$reward_info)
            $reward_info = new LotteryRewardInfo();
        return $reward_info;
    }

    public function list($limit, $user_id, $product_id, $status): LengthAwarePaginator
    {
        if ($user_id)
            $this->rewardRepo->pushCriteria(new BelongToUserCriteria($user_id));
        if ($product_id)
            $this->rewardRepo->pushCriteria(new LotteryRewardBelongToSessionHasProductIdCriteria($product_id));
        if ($status)
            $this->rewardRepo->pushCriteria(new HasStatusCriteria($status));

        $this->rewardRepo->with([
            'session.product',
            'lottery',
            'info',
            'user',
            'info.district',
            'info.province',
        ]);

        return $this->rewardRepo->paginate($limit);
    }

    public function updateRewardStatus($id, $status) {
        /** @var LotteryReward $reward */
        $reward = $this->rewardRepo->find($id);
        if (!in_array($status, RewardStatus::getValues()))
            throw new ExecuteException(__('Trạng thái không hợp lệ'));
        $reward->status = $status;
        return $this->rewardRepo->save($reward);
    }
}
