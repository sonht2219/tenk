<?php


namespace App\Service\Contract;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LotterySessionService
{
    public function createLotterySession(Product $product);
    public function single($id): LotterySession;
    public function singleByProductAndStatus($product_id, $status = LotterySessionStatus::SELLING);
    public function historyLotterySession($session_id, $limit): LengthAwarePaginator;
    public function list($limit, $search, $status = LotterySessionStatus::SELLING): LengthAwarePaginator;
    public function listSessionOpeningAndEnded($limit): LengthAwarePaginator;
}
