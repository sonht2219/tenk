<?php


namespace App\Service\Contract;


use App\Models\LotterySession;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LotterySessionService
{
    public function create(Product $product);
    public function single($id): LotterySession;
    public function historyLotterySession($session_id, $limit): LengthAwarePaginator;
}
