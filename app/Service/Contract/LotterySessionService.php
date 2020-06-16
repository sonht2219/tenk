<?php


namespace App\Service\Contract;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LotterySessionService
{
    public function create(Product $product);
    public function single($id): LotterySession;
    public function listLotteries($id, $search, $limit): LengthAwarePaginator;
    public function buyLotteries($session_id, $lottery_ids);

    public function list($limit, $search, $status = LotterySessionStatus::SELLING): LengthAwarePaginator;
}
