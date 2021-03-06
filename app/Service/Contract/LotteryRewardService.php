<?php


namespace App\Service\Contract;


use App\Http\Requests\ReceiveRewardRequest;
use App\Models\LotteryReward;
use App\Models\LotterySession;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface LotteryRewardService
{
    public function create(LotterySession $session): LotteryReward;
    public function listRewardOfProduct($product_id, $limit): LengthAwarePaginator;
    public function history(Request $req, User $user): LengthAwarePaginator;
    public function receiveReward(ReceiveRewardRequest $req, User $user);
    public function list($limit, $user_id, $product_id, $status): LengthAwarePaginator;
    public function updateRewardStatus($id, $status);
}
