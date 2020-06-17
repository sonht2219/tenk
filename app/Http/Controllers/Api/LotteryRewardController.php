<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotteryRewardService;
use Illuminate\Http\Request;

class LotteryRewardController extends Controller
{
    private LotteryRewardService $rewardService;
    private DtoBuilderService $dtoBuilder;

    public function __construct(LotteryRewardService $rewardService, DtoBuilderService $dtoBuilder)
    {
        $this->rewardService = $rewardService;
        $this->dtoBuilder = $dtoBuilder;
    }

    public function listRewardOfProduct($product_id, Request $req) {
        $limit = $req->get('limit') ?: 10;
        $rewards = $this->rewardService->listRewardOfProduct($product_id, $limit);
        return [
            'datas' => collect($rewards->items())->map(fn($reward) => $this->dtoBuilder->buildLotteryRewardDto($reward)),
            'meta' => get_meta($rewards)
        ];
    }
}
