<?php


namespace App\Http\Controllers\Api;


use App\Enum\Status\LotterySessionStatus;
use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuyLotteryRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotterySessionService;
use Illuminate\Http\Request;

class LotterySessionController extends Controller
{
    use AuthorizedController;

    private LotterySessionService $lotterySessionService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(LotterySessionService $lotterySessionService, DtoBuilderService $dtoBuilder)
    {
        $this->lotterySessionService = $lotterySessionService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function sellingSessions(Request $req) {
        return $this->listSessions($req);
    }

    public function countDowningSessions(Request $req) {
        return $this->listSessions($req, LotterySessionStatus::COUNT_DOWNING);
    }

    private function listSessions(Request $req, $status = LotterySessionStatus::SELLING) {
        $limit = $req->get('limit') ?: 20;
        $search = $req->get('search');
        $sessions_page = $this->lotterySessionService->list($limit, $search, $status);

        return [
            'datas' => collect($sessions_page->items())->map(fn($item) => $this->dtoBuilder->buildLotterySessionDto($item)),
            'meta' => get_meta($sessions_page)
        ];
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
