<?php


namespace App\Service\Contract;


use App\Enum\Status\LotterySessionStatus;
use App\Models\LotterySession;
use App\Models\Product;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface LotterySessionService
{
    public function createLotterySession(Product $product);
    public function single($id): LotterySession;
    public function singleByProductAndStatus($product_id, $status = LotterySessionStatus::SELLING);
    public function historyLotterySession($session_id, $limit): LengthAwarePaginator;
    public function list($limit, $search, $status = LotterySessionStatus::SELLING): LengthAwarePaginator;
    public function listSessionOpeningAndEnded($limit): LengthAwarePaginator;
    public function historyMine(Request $req, User $user): LengthAwarePaginator;
    public function countByStatus($status);
    public function userJoinedSession($session_id, $user_id): bool;
    public function statisticSessionByDay($from, $to);
    public function statisticTopProduct($from, $to, $limit);
    public function statisticTotalRevenue($from, $to);
}
