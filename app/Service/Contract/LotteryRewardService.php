<?php


namespace App\Service\Contract;


use App\Models\LotterySession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LotteryRewardService
{
    public function create(LotterySession $session);
    public function listRewardOfProduct($product_id, $limit): LengthAwarePaginator;
}
