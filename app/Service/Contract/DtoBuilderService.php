<?php


namespace App\Service\Contract;


use App\Models\Article;
use App\Models\Banner;
use App\Models\Bot;
use App\Models\Feedback;
use App\Models\Lottery;
use App\Models\LotteryReward;
use App\Models\LotterySession;
use App\Models\PhoneCard;
use App\Models\Product;
use App\Models\Transaction;
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
    public function buildTransactionDto(Transaction $transaction);
    public function buildArticleDto(Article $article);
    public function buildBannerDto(Banner $banner);
    public function buildBotDto(Bot $bot);
    public function buildStatisticRevenueByDay($revenue_statistic);
    public function buildStatisticTopUser($top_user);
    public function buildStatisticSessionByDay($session_statistic);
    public function buildStatisticTopProduct($top_product, $total);
    public function buildPhoneCardDto(PhoneCard $phone_card);
}
