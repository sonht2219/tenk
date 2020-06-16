<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
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
        $session_id = $req->get('session_id');
        $lottery_ids = $req->get('lottery_ids');

        return $this->lotteryService->buyLotteries($session_id, $lottery_ids);
    }
}
