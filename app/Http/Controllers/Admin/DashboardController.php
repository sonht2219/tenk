<?php


namespace App\Http\Controllers\Admin;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotteryService;
use App\Service\Contract\LotterySessionService;
use App\Service\Contract\ProductService;
use App\Service\Contract\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AuthorizedController;

    private UserService $userService;
    private ProductService $productService;
    private LotterySessionService $sessionService;
    private LotteryService $lotteryService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(
        UserService $userService,
        ProductService $productService,
        LotterySessionService $sessionService,
        LotteryService $lotteryService,
        DtoBuilderService $dtoBuilder
    )
    {
        $this->userService = $userService;
        $this->productService = $productService;
        $this->sessionService = $sessionService;
        $this->lotteryService = $lotteryService;
        $this->dtoBuilder = $dtoBuilder;
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

    public function statisticRevenue(Request $req) {
        $from = $req->get('from');
        $to = $req->get('to');
        $revenue_statistic = $this->lotteryService->statisticByDay($from, $to);
        return collect($revenue_statistic)->map(fn($obj) => $this->dtoBuilder->buildStatisticRevenueByDay($obj));
    }

    public function statisticTopUser(Request $req) {
        $data = $this->parserDataFromReq($req);
        $top_user = $this->lotteryService->statisticTopUser($data['from'], $data['to']);
        return collect($top_user)->map(fn($obj) => $this->dtoBuilder->buildStatisticTopUser($obj));
    }

    public function statisticSession(Request $req) {
        $data = $this->parserDataFromReq($req);
        $session_statistic = $this->sessionService->statisticSessionByDay($data['from'], $data['to']);
        return collect($session_statistic)->map(fn($obj) => $this->dtoBuilder->buildStatisticSessionByDay($obj));
    }

    public function statisticTopProduct(Request $req) {
        $data = $this->parserDataFromReq($req);
        $top_product = $this->sessionService->statisticTopProduct($data['from'], $data['to']);
        return collect($top_product)->map(fn($obj) => $this->dtoBuilder->buildStatisticTopProduct($obj));
    }

    private function parserDataFromReq(Request $req) {
        $from = $req->get('from') ? Carbon::createFromTimestampMs($req->get('from')) : null;
        $to = $req->get('to') ? Carbon::createFromTimestampMs($req->get('to')) : null;
        return compact('from', 'to');
    }
}
