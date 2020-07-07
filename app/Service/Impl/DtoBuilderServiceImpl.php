<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Enum\Status\RewardStatus;
use App\Enum\Status\TransactionStatus;
use App\Enum\Telco;
use App\Enum\Type\UserAddressType;
use App\Helper\Constant;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Bot;
use App\Models\Feedback;
use App\Models\Lottery;
use App\Models\LotteryReward;
use App\Models\LotteryRewardInfo;
use App\Models\LotterySession;
use App\Models\PhoneCard;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\FileService;
use App\Service\Contract\LotteryService;
use App\User;
use Carbon\Carbon;

class DtoBuilderServiceImpl implements DtoBuilderService
{
    private FileService $fileService;
    private LotteryService $lotteryService;

    public function __construct(FileService $fileService, LotteryService $lotteryService)
    {
        $this->fileService = $fileService;
        $this->lotteryService = $lotteryService;
    }

    public function buildProductDto(Product $product)
    {
        $images = explode(',', $product->images);
        $result = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'images' => $images,
            'image_urls' => collect($images)->map(fn($img) => $this->fileService->uploaded_url($img)),
            'status' => $product->status,
            'status_title' => CommonStatus::getDescription($product->status),
            'created_at' => $product->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $product->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'price' => $product->price,
            'original_price' => $product->original_price,
            'original_price_pretty' => number_format($product->original_price),
            'thumbnail' => $product->thumbnail,
            'thumbnail_url' => $this->fileService->uploaded_url($product->thumbnail),
            'creator_id' => $product->creator_id,
            'use_bot' => $product->use_bot,
        ];

        if ($product->relationLoaded('creator') && $product->creator)
            $result['creator'] = $product->creator;

        return $result;
    }
    /**
     * @inheritDoc
     */
    public function buildUserDto(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'avatar_url' => $user->avatar ? $this->fileService->uploaded_url($user->avatar) : $user->avatar,
            'birthday' => $user->birthday ? $user->birthday->getTimestamp() * 1000 : null,
            'status' => $user->status,
            'created_at' => $user->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $user->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];
    }

    public function buildLotterySessionDto(LotterySession $lottery_session)
    {
        $result = [
            'id' => $lottery_session->id,
            'product_id' => $lottery_session->product_id,
            'price' => $lottery_session->price,
            'product' => null,
            'time_end' => $lottery_session->time_end,
            'sold_quantity' => $lottery_session->sold_quantity,
            'status' => $lottery_session->status,
            'status_title' => LotterySessionStatus::getDescription($lottery_session->status),
            'reward' => null,
            'created_at' => $lottery_session->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $lottery_session->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'remain_time_mls' => $lottery_session->time_end ? ($lottery_session->time_end - round(microtime(true) * 1000)) : null
        ];

        if ($lottery_session->relationLoaded('product') && $lottery_session->product)
            $result['product'] = $this->buildProductDto($lottery_session->product);
        if ($lottery_session->relationLoaded('reward') && $lottery_session->reward)
            $result['reward'] = $this->buildLotteryRewardDto($lottery_session->reward);

        return $result;
    }

    public function buildLotteryDto(Lottery $lottery)
    {
        $result = [
            'id' => $lottery->id,
            'session_id' => $lottery->session_id,
            'session' => null,
            'serial' => $lottery->serial,
            'user_id' => $lottery->user_id,
            'user' => null,
            'joined_at' => $lottery->joined_at,
            'status' => $lottery->status,
            'status_title' => LotteryStatus::getDescription($lottery->status),
            'created_at' => $lottery->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $lottery->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($lottery->relationLoaded('session') && $lottery->session)
            $result['session'] = $this->buildLotterySessionDto($lottery->session);
        if ($lottery->relationLoaded('user') && $lottery->user)
            $result['user'] = $this->buildUserDto($lottery->user);

        return $result;
    }

    public function buildHistoryLotteryDto($history)
    {
        return [
            'id' => $history->user_id,
            'user_id' => $history->user_id,
            'session_id' => $history->session_id,
            'user' => $this->buildUserDto($history->user),
            'joined_at' => $history->joined_at ? Carbon::createFromTimestampMs($history->joined_at)->format(Constant::FULL_TIME_FORMAT) : null,
            'join_number' => $history->join_number
        ];
    }

    public function buildLotteryRewardDto(LotteryReward $lottery_reward)
    {
        $result = [
            'id' => $lottery_reward->id,
            'session_id' => $lottery_reward->session_id,
            'session' => null,
            'user_id' => $lottery_reward->user_id,
            'user' => null,
            'lottery_id' => $lottery_reward->lottery_id,
            'lottery' => null,
            'join_times' => $lottery_reward->join_times,
            'status' => $lottery_reward->status,
            'status_title' => RewardStatus::getDescription($lottery_reward->status),
            'created_at' => $lottery_reward->created_at->format(Constant::FULL_TIME_FORMAT),
            'updated_at' => $lottery_reward->updated_at->format(Constant::FULL_TIME_FORMAT)
        ];

        if ($lottery_reward->relationLoaded('session') && $lottery_reward->session)
            $result['session'] = $this->buildLotterySessionDto($lottery_reward->session);
        if ($lottery_reward->relationLoaded('user') && $lottery_reward->user)
            $result['user'] = $this->buildUserDto($lottery_reward->user);
        if ($lottery_reward->relationLoaded('lottery') && $lottery_reward->lottery)
            $result['lottery'] = $this->buildLotteryDto($lottery_reward->lottery);
        if ($lottery_reward->relationLoaded('info') && $lottery_reward->info)
            $result['info'] = $this->buildLotteryRewardInfoDto($lottery_reward->info);

        return $result;
    }

    public function buildFeedbackDto(Feedback $feedback)
    {
        $result = [
            'id' => $feedback->id,
            'user_id' => $feedback->user_id,
            'session_id' => $feedback->session_id,
            'product_id' => $feedback->product_id,
            'lottery_id' => $feedback->lottery_id,
            'created_at' => $feedback->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $feedback->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'status' => $feedback->status,
            'status_title' => CommonStatus::getDescription($feedback->status),
            'images' => $feedback->images
                ? collect(explode(',', $feedback->images))
                    ->map(fn($img) => $this->fileService->uploaded_url($img))
                : null,
            'content' => $feedback->content,
        ];

        if ($feedback->relationLoaded('user') && $feedback->user)
            $result['user'] = $this->buildUserDto($feedback->user);

        if ($feedback->relationLoaded('session') && $feedback->session)
            $result['session'] = $this->buildLotterySessionDto($feedback->session);

        if ($feedback->relationLoaded('product') && $feedback->product)
            $result['product'] = $this->buildProductDto($feedback->product);

        if ($feedback->relationLoaded('lottery') && $feedback->lottery)
            $result['lottery'] = $this->buildLotteryDto($feedback->lottery);

        return $result;

    }

    public function buildUserAddressDto(UserAddress $user_address)
    {
        $result = [
            'id' => $user_address->id,
            'user_id' => $user_address->user_id,
            'name' => $user_address->name,
            'phone_number' => $user_address->phone_number,
            'address' => $user_address->address,
            'province_id' => $user_address->province_id,
            'district_id' => $user_address->district_id,
            'province' => null,
            'district' => null,
            'type' => $user_address->type,
            'type_title' => UserAddressType::getDescription($user_address->type),
            'status' => $user_address->status,
            'status_title' => CommonStatus::getDescription($user_address->status),
            'created_at' => $user_address->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $user_address->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($user_address->relationLoaded('province') && $user_address->province)
            $result['province'] = $user_address->province;
        if ($user_address->relationLoaded('district') && $user_address->district)
            $result['district'] = $user_address->district;

        return $result;
    }

    public function buildLotteryRewardInfoDto(LotteryRewardInfo $info)
    {
        $result = [
            'id' => $info->id,
            'reward_id' => $info->reward_id,
            'name' => $info->name,
            'phone_number' => $info->phone_number,
            'address' => $info->address,
            'province_id' => $info->province_id,
            'district_id' => $info->district_id,
            'created_at' => $info->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $info->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($info->relationLoaded('province') && $info->province)
            $result['province'] = $info->province;
        if ($info->relationLoaded('district') && $info->district)
            $result['district'] = $info->district;

        return $result;
    }

    public function buildTransactionDto(Transaction $transaction)
    {
        $result = [
            'id' => $transaction->id,
            'value' => $transaction->value,
            'old_cash' => $transaction->old_cash,
            'new_cash' => $transaction->new_cash,
            'user_id' => $transaction->user_id,
            'description' => $transaction->description,
            'status' => $transaction->status,
            'status_title' => TransactionStatus::getDescription($transaction->status),
            'transaction_cash_detail' => null,
            'user' => null,
            'created_at' => $transaction->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $transaction->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($transaction->relationLoaded('cash_detail') && $transaction->cash_detail)
            $result['transaction_cash_detail'] = $transaction->cash_detail;
        if ($transaction->relationLoaded('user') && $transaction->user)
            $result['user'] = $this->buildUserDto($transaction->user);

        return $result;
    }

    public function buildArticleDto(Article $article)
    {
        return [
            'id' => $article->id,
            'slug' => $article->slug,
            'title' => $article->title,
            'description' => $article->description,
            'content' => $article->content,
            'author' => $article->author,
            'thumbnail' => $article->thumbnail,
            'thumbnail_url' => $this->fileService->uploaded_url($article->thumbnail),
            'status' => $article->status,
            'status_title' => CommonStatus::getDescription($article->status),
            'seen' => $article->seen,
            'created_at' => $article->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $article->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'created_by_id' => $article->created_by_id,
            'link' => route('article_webview', ['slug' => $article->slug]),
        ];
    }

    public function buildBannerDto(Banner $banner)
    {
        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'banner_type_id' => $banner->banner_type_id,
            'navigate_to' => $banner->navigate_to,
            'image' => $banner->image,
            'image_url' => $this->fileService->uploaded_url($banner->image),
            'created_at' => $banner->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $banner->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'status' => $banner->status,
            'status_title' => CommonStatus::getDescription($banner->status),
            'ordinal_number' => $banner->ordinal_number,
        ];
    }

    public function buildBotDto(Bot $bot)
    {
        $result = [
            'id' => $bot->id,
            'user_id' => $bot->user_id,
            'created_at' => $bot->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $bot->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'status' => $bot->status,
            'status_title' => CommonStatus::getDescription($bot->status),
            'limit_per_buy' => $bot->limit_per_buy,
        ];

        if ($bot->relationLoaded('user') && $bot->user)
            $result['user'] = $this->buildUserDto($bot->user);

        return $result;
    }

    public function buildStatisticRevenueByDay($revenue_statistic)
    {
        return [
            'date' => $revenue_statistic->date,
            'value' => $revenue_statistic->total_lottery * $this->lotteryService->getUnitPriceLottery() * 1000
        ];
    }

    public function buildStatisticTopUser($top_user)
    {
        return [
            'user_id' => $top_user->user_id,
            'user' => $top_user->user,
            'value' => $top_user->total_lottery * $this->lotteryService->getUnitPriceLottery() * 1000
        ];
    }

    public function buildStatisticSessionByDay($session_statistic)
    {
        return [
            'date' => $session_statistic->date,
            'value' => $session_statistic->total_session
        ];
    }

    public function buildStatisticTopProduct($top_product, $total)
    {
        return [
            'product_id' => $top_product->product_id,
            'product' => $top_product->product,
            'product_name' => $top_product->product->name,
            'value' => $top_product->total_revenue,
            'percent' => round($top_product->total_revenue * 100 / $total)
        ];
    }

    public function buildPhoneCardDto(PhoneCard $phone_card)
    {
        $result = [
            'id' => $phone_card->id,
            'seri' => $phone_card->seri,
            'code' => $phone_card->code,
            'telco' => $phone_card->telco,
            'telco_title' => Telco::getKey($phone_card->telco),
            'value' => $phone_card->value,
            'true_value' => $phone_card->true_value,
            'card_value' => $phone_card->card_value,
            'status' => $phone_card->status,
            'transaction_id' => $phone_card->transaction_id,
            'transaction' => null,
            'created_at' => $phone_card->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $phone_card->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($phone_card->relationLoaded('transaction') && $phone_card->transaction)
            $result['transaction'] = $this->buildTransactionDto($phone_card->transaction);

        return $result;
    }
}
