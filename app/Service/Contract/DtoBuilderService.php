<?php


namespace App\Service\Contract;


use App\Models\Feedback;
use App\Models\Lottery;
use App\Models\LotteryReward;
use App\Models\LotterySession;
use App\Models\Product;
use App\Models\UserAddress;
use App\User;

interface DtoBuilderService
{
    public function buildUserDto(User $user);
    public function buildProductDto(Product $product);
    public function buildLotterySessionDto(LotterySession $lottery_session);
    public function buildLotteryDto(Lottery $lottery);
    public function buildHistoryLotteryDto($history);
    public function buildLotteryRewardDto(LotteryReward $lottery_reward);
    public function buildFeedbackDto(Feedback $feedback);
    public function buildUserAddressDto(UserAddress $user_address);
}
