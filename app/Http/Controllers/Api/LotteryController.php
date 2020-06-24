<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\AllLotteryByUserAndSessionRequest;
use App\Http\Requests\BuyLotteryRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotteryService;
use Illuminate\Http\Request;

class LotteryController extends Controller
{

    private LotteryService $lotteryService;
    private DtoBuilderService $dtoBuilder;
    public function __construct(LotteryService $lotteryService, DtoBuilderService $dtoBuilder)
    {
        $this->lotteryService = $lotteryService;
        $this->dtoBuilder = $dtoBuilder;
    }
    public function listLotteries($id, Request $req) {
        $search = $req->get('search');
        $limit = $req->get('limit') ?: 10;

        $lotteries = $this->lotteryService->listLotteries($id, $search, $limit);

        return [
            'datas' => collect($lotteries->items())->map(function ($lottery) {
                return $this->dtoBuilder->buildLotteryDto($lottery);
            }),
            'meta' => get_meta($lotteries)
        ];
    }

    public function buyLotteries(BuyLotteryRequest $req) {
        return $this->lotteryService->buyLotteries($req);
    }

    public function detailHistoryBuyLottery(AllLotteryByUserAndSessionRequest $req) {
        $session_id = $req->get('session_id');
        $user_id = $req->get('user_id');
        $history = $this->lotteryService->getHistoryBuyLotteryOfSession($session_id, $user_id);
        return [
            'lotteries' => $this->lotteryService->allLotteriesOfUserInLotterySession($session_id, $user_id),
            'history' => $history && count($history) ? $this->dtoBuilder->buildHistoryLotteryDto($history[0]) : null
        ];
    }
}
