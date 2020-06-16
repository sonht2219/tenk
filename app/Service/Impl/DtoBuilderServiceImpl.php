<?php


namespace App\Service\Impl;


use App\Enum\Status\CommonStatus;
use App\Helper\Constant;
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
}
