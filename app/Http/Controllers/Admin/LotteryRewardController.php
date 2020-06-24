<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotteryRewardService;
use Illuminate\Http\Request;

class LotteryRewardController extends Controller
{
    private DtoBuilderService $dtoBuilder;
    private LotteryRewardService $rewardService;

    public function __construct(DtoBuilderService $dtoBuilder, LotteryRewardService $rewardService)
    {
        $this->dtoBuilder = $dtoBuilder;
        $this->rewardService = $rewardService;
    }

    public function list(Request $req) {
        $limit = $req->get('limit') ?: 20;
        $user_id = $req->get('user_id');
        $product_id = $req->get('product_id');
        $status = $req->get('status');

        $page = $this->rewardService->list($limit, $user_id, $product_id, $status);

        return [
            'datas' => collect($page->items())->map(fn($reward) => $this->dtoBuilder->buildLotteryRewardDto($reward)),
            'meta' => get_meta($page)
        ];
    }

    public function updateStatus($id, Request $req) {
        return $this->dtoBuilder->buildLotteryRewardDto(
            $this->rewardService->updateRewardStatus($id, $req->get('status'))
        );
    }
}
