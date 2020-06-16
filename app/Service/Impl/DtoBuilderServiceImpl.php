<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotterySessionStatus;
use App\Enum\Status\LotteryStatus;
use App\Helper\Constant;
use App\Models\Lottery;
use App\Models\LotterySession;
use App\Models\Product;
use App\Service\Contract\DtoBuilderService;
use App\User;

class DtoBuilderServiceImpl implements DtoBuilderService
{

    public function buildProductDto(Product $product)
    {
        $images = explode(',', $product->images);
        $result = [
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'images' => $images,
            'image_urls' => collect($images),
            'status' => $product->status,
            'status_title' => CommonStatus::getDescription($product->status),
            'created_at' => $product->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $product->updated_at->format(Constant::GLOBAL_TIME_FORMAT),
            'price' => $product->price,
            'original_price' => $product->original_price,
            'thumbnail' => $product->thumbnail,
            'thumbnail_url' => $product->thumbnail,
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
            'created_at' => $lottery_session->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $lottery_session->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($lottery_session->relationLoaded('product'))
            $result['product'] = $lottery_session->product;

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
            'status' => $lottery->status,
            'status_title' => LotteryStatus::getDescription($lottery->status),
            'created_at' => $lottery->created_at->format(Constant::GLOBAL_TIME_FORMAT),
            'updated_at' => $lottery->updated_at->format(Constant::GLOBAL_TIME_FORMAT)
        ];

        if ($lottery->relationLoaded('session'))
            $result['session'] = $lottery->session;
        if ($lottery->relationLoaded('user'))
            $result['user'] = $lottery->user;

        return $result;
    }
}
