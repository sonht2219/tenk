<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\BuyLotteryRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotterySessionService;
use Illuminate\Http\Request;

class LotterySessionController extends Controller
{
    private LotterySessionService $lotterySessionService;
    private DtoBuilderService $dtoBuilder;
    public function __construct(LotterySessionService $lotterySessionService, DtoBuilderService $dtoBuilder)
    {
        $this->lotterySessionService = $lotterySessionService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function single($id) {
        return $this->dtoBuilder->buildLotterySessionDto($this->lotterySessionService->single($id));
    }

    public function listLotteries($id, Request $req) {
        $search = $req->get('search');
        $limit = $req->get('limit') ?: 10;

        $lotteries = $this->lotterySessionService->listLotteries($id, $search, $limit);

        return [
            'datas' => collect($lotteries->items())->map(function ($lottery) {
                return $this->dtoBuilder->buildLotteryDto($lottery);
            }),
            'meta' => get_meta($lotteries)
        ];
    }

    public function buyLottery(BuyLotteryRequest $req) {

    }
}
