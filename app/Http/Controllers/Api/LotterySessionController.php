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

    public function historyLotterySession($id, Request $req) {
        $limit = $req->get('limit') ?: 10;
        $histories = $this->lotterySessionService->historyLotterySession($id, $limit);
        return [
            'datas' => collect($histories->items())->map(fn($history) => $this->dtoBuilder->buildHistoryLotteryDto($history)),
            'meta' => get_meta($histories)
        ];
    }
}
