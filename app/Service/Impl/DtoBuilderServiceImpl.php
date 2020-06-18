<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Enum\Status\RewardStatus;
use App\Helper\Constant;
use App\Models\Feedback;
use App\Models\Lottery;
use App\Models\LotteryReward;
use App\Models\LotterySession;
use App\Models\Product;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\FileService;
use App\User;
use Carbon\Carbon;

class DtoBuilderServiceImpl implements DtoBuilderService
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function buildProductDto(Product $product)
    {
        $images = explode(',', $product->images);
        $result = [
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
            'thumbnail' => $product->thumbnail,
            'thumbnail_url' => $this->fileService->uploaded_url($product->thumbnail),
            'creator_id' => $product->creator_id
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
                : null
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
}