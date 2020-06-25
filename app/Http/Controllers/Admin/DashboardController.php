<?php


namespace App\Http\Controllers\Admin;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Service\Contract\LotteryService;
use App\Service\Contract\LotterySessionService;
use App\Service\Contract\ProductService;
use App\Service\Contract\UserService;

class DashboardController extends Controller
{
    use AuthorizedController;

    private UserService $userService;
    private ProductService $productService;
    private LotterySessionService $sessionService;
    private LotteryService $lotteryService;

    public function __construct(
        UserService $userService,
        ProductService $productService,
        LotterySessionService $sessionService,
        LotteryService $lotteryService
    )
    {
        $this->userService = $userService;
        $this->productService = $productService;
        $this->sessionService = $sessionService;
        $this->lotteryService = $lotteryService;
    }

    public function usersCount()
    {
        return [
            'total' => $this->userService->countByStatus(null),
            'active' => $this->userService->countByStatus(CommonStatus::ACTIVE)
        ];
    }

    public function productsCount()
    {
        return [
            'total' => $this->productService->countProductsByStatus(null),
            'active' => $this->productService->countProductsByStatus(CommonStatus::ACTIVE)
        ];
    }

    public function sessionsCount()
    {
        return [
            'total' => $this->sessionService->countByStatus(null),
            'selling' => $this->sessionService->countByStatus(LotterySessionStatus::SELLING),
            'count_downing' => $this->sessionService->countByStatus(LotterySessionStatus::COUNT_DOWNING),
            'ended' => $this->sessionService->countByStatus(LotterySessionStatus::ENDING)
        ];
    }

    public function lotteriesCount()
    {
        $total = $this->lotteryService->countSoldLottery();
        return [
            'total' => $total,
            'revenue' => $total * $this->lotteryService->getUnitPriceLottery() * 1000
        ];
    }
}
